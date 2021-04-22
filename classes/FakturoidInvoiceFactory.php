<?php namespace VojtaSvoboda\ShopaholicFakturoid\Classes;

use Config;
use Lovata\OrdersShopaholic\Models\Order;
use System\Classes\PluginManager;
use VojtaSvoboda\Fakturoid\Models\Settings;

class FakturoidInvoiceFactory
{
    /**
     * @param Order $order
     * @param int $fakturoid_user_id
     * @return array
     */
    public function prepareInvoiceDataFromOrder(Order $order, $fakturoid_user_id)
    {
        // order locale
        $locale = $this->getTranslationLocale($order);

        // order lines
        $lines = $this->getOrderLines($order, $locale);

        // prepare invoice data
        $invoice = [
            'custom_id' => $order->id,
            'subject_id' => $fakturoid_user_id,
            'currency' => !empty($order->currency) ? $order->currency->code : null,
            'payment_method' => !empty($order->payment_method) ? $order->payment_method->code : null,
            'lines' => $lines,
        ];

        // if order has user
        if ($order->user !== null) {
            $user = $order->user;

            // add user due date days if additional property code set
            $field = Settings::get('additional_properties_user_due_date_days');
            if ($field !== null && isset($user->property[$field])) {
                $due_date_days = $user->property[$field];
                if (is_numeric($due_date_days) && $due_date_days > 0) {
                    $invoice['due'] = (int) $due_date_days;
                }
            }
        }

        return $invoice;
    }

    /**
     * @param Order $order
     * @param string $locale
     * @return array
     */
    private function getOrderLines(Order $order, $locale)
    {
        $lines = [];

        // prepare order lines
        foreach ($order->order_position as $position) {
            $offer = $position->offer;
            $measure = $offer->measure;

            // calculate 'price without VAT' without any rounding to have prices as precisely as possible
            // because $position->price_without_tax_value is rounded to 2 decimal points
            $price_without_vat = ($position->price_with_tax_value * 100) / (100 + $position->tax_percent);

            // offer name could be translated
            $name = $offer->name;
            if (PluginManager::instance()->exists('RainLab.Translate')) {
                $name = $offer->lang($locale)->name;
            }

            $lines[] = [
                'name' => $name,
                'quantity' => $position->quantity,
                'unit_name' => !empty($measure) ? $measure->code : null,
                'unit_price' => $price_without_vat,
                'unit_price_without_vat' => $price_without_vat,
                'unit_price_with_vat' => $position->price_with_tax_value,
                'vat_rate' => $position->tax_percent,
            ];
        }

        // add delivery as order line if not empty
        $delivery = $this->getOrderShippingAsLine($order, $locale);
        if (!empty($delivery)) {
            $lines[] = $delivery;
        }

        return $lines;
    }

    /**
     * @param Order $order
     * @param string $locale
     * @return array
     */
    private function getOrderShippingAsLine(Order $order, $locale)
    {
        // shipping price
        $price = (float) $order->shipping_price;

        // skip if price is for free and we have disabled inserting empty shipping
        if (empty($price)) {
            $include_delivery_empty = (bool) Settings::get('settings_include_empty_delivery', false);
            if ($include_delivery_empty === false) {
                return [];
            }
        }

        // shipping name
        $name = $order->shipping_type->name;
        if (PluginManager::instance()->exists('RainLab.Translate')) {
            $name = $order->shipping_type->lang($locale)->name;
        }

        // price without vat
        $price_without_vat = $price;
        if (!empty($price) && $order->shipping_tax_percent > 0) {
            $price_without_vat = ($price * 100) / (100 + $order->shipping_tax_percent);
        }

        return [
            'name' => $name,
            'quantity' => 1,
            'unit_price' => $price_without_vat,
            'vat_rate' => !empty($order->shipping_tax_percent) ? $order->shipping_tax_percent : 0,
        ];
    }

    /**
     * @param Order $order
     * @return string|null
     */
    private function getTranslationLocale(Order $order)
    {
        if (empty($order->property['billing_country'])) {
            return null;
        }

        $country = mb_strtolower($order->property['billing_country']);
        $countryLocales = Config::get('vojtasvoboda.shopaholicfakturoid::locales', []);

        return isset($countryLocales[$country]) ? $countryLocales[$country] : null;
    }
}
