<?php namespace VojtaSvoboda\ShopaholicFakturoid\Classes;

use Config;
use Lovata\Buddies\Models\User;
use Lovata\OrdersShopaholic\Models\Order;
use VojtaSvoboda\Fakturoid\Models\Settings;

class FakturoidUserFactory
{
    /**
     * Prepare Fakturoid user (subject) data from existing Order and User.
     *
     * @param Order $order
     * @param User $user
     * @return array
     */
    public function prepareUserDataFromOrderAndUser(Order $order, User $user)
    {
        // get fakturoid user data just from Order
        $data = $this->prepareUserDataFromOrder($order);

        // existing user
        $data['custom_id'] = $user->id;

        // we can use user's email and phone, if missing in order
        if (empty($data['email'])) {
            $data['email'] = trim($user->email);
        }
        if (empty($data['phone'])) {
            $data['phone'] = trim($user->phone);
        }

        // we can use user's name, if missing in order
        if (empty($data['name'])) {
            $data['name'] = $this->getUserFullName($user);
            $data['full_name'] = $data['name'];
        }

        return $data;
    }

    /**
     * Prepare Fakturoid user (subject) data from existing Order.
     *
     * @param Order $order
     * @return array
     */
    public function prepareUserDataFromOrder(Order $order)
    {
        // user email and phone
        $email = !empty(trim($order->property['email'])) ? trim($order->property['email']) : null;
        $phone = !empty(trim($order->property['phone'])) ? trim($order->property['phone']) : null;

        // try to use company name, otherwise use user name
        $name = $this->getOrderCompanyName($order);
        if (empty($name)) {
            $name = $this->getOrderFullName($order);
        }

        // user address
        $order_street = !empty($order->property['billing_street']) ? trim($order->property['billing_street']) : null;
        $order_house = !empty($order->property['billing_house']) ? trim($order->property['billing_house']) : null;
        $street = trim($order_street . ' ' . $order_house);
        $city = !empty($order->property['billing_city']) ? $order->property['billing_city'] : null;
        $zip = !empty($order->property['billing_postcode']) ? $order->property['billing_postcode'] : null;
        $country = $this->getCountryFromOrder($order);

        // invoicing details
        $reg_no_key = Settings::get('additional_properties_company_reg_no');
        $registration_no = !empty($order->property[$reg_no_key]) ? $order->property[$reg_no_key] : null;
        $vat_no_key = Settings::get('additional_properties_company_vat_no');
        $vat_no = !empty($order->property[$vat_no_key]) ? $order->property[$vat_no_key] : null;

        // return user data
        return [
            'email' => $email,
            'name' => $name,
            'full_name' => $name,
            'phone' => $phone,
            'street' => $street,
            'city' => $city,
            'zip' => $zip,
            'country' => $country,
            'registration_no' => $registration_no,
            'vat_no' => $vat_no,
        ];
    }

    /**
     * @param User $user
     * @return string
     */
    private function getUserFullName(User $user)
    {
        return implode(' ', [
            trim($user->name),
            trim($user->middle_name),
            trim($user->last_name),
        ]);
    }

    /**
     * @param Order $order
     * @return string
     */
    private function getOrderFullName(Order $order)
    {
        $parts = [];

        if (!empty($order->property['name'])) {
            $parts[] = trim($order->property['name']);
        }

        if (!empty($order->property['last_name'])) {
            $parts[] = trim($order->property['last_name']);
        }

        return implode(' ', $parts);
    }

    /**
     * @param Order $order
     * @return string|null
     */
    private function getOrderCompanyName(Order $order)
    {
        // if having company name property set, return company name
        $company_name_key = Settings::get('additional_properties_company_name');
        if (empty($company_name_key) || empty($order->property[$company_name_key])) {
            return null;
        }

        return $order->property[$company_name_key];
    }

    /**
     * @param Order $order
     * @return string|null
     */
    private function getCountryFromOrder(Order $order)
    {
        if (empty($order->currency_id) || empty($order->property['billing_country'])) {
            return null;
        }

        $country = mb_strtolower($order->property['billing_country']);
        $countryCodes = Config::get('vojtasvoboda.shopaholicfakturoid::country_codes', []);

        return isset($countryCodes[$country]) ? $countryCodes[$country] : null;
    }
}
