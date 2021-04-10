<?php namespace VojtaSvoboda\ShopaholicFakturoid\Services;

use Fakturoid\Exception;
use Lovata\Buddies\Models\User;
use Lovata\OrdersShopaholic\Models\Order;
use October\Rain\Exception\ApplicationException;
use stdClass;
use VojtaSvoboda\Fakturoid\Services\InvoiceService;
use VojtaSvoboda\Fakturoid\Services\SubjectService;
use VojtaSvoboda\ShopaholicFakturoid\Classes\FakturoidInvoiceFactory;
use VojtaSvoboda\ShopaholicFakturoid\Classes\FakturoidUserFactory;

class OrderService
{
    /** @var Order $orders */
    private $orders;

    /** @var InvoiceService $invoices */
    private $invoices;

    /** @var SubjectService $subjects */
    private $subjects;

    /**
     * @param Order $orders
     * @param InvoiceService $invoices
     * @param SubjectService $subjects
     */
    public function __construct(Order $orders, InvoiceService $invoices, SubjectService $subjects)
    {
        $this->orders = $orders;
        $this->invoices = $invoices;
        $this->subjects = $subjects;
    }

    /**
     * @param int $order_id
     * @throws ApplicationException|Exception
     */
    public function createInvoiceForOrder($order_id)
    {
        $refreshContact = false;
        try {
            // try to create new invoice
            $this->processCreateInvoiceForOrder($order_id);

        } catch (Exception $e) {
            $reponse = json_decode($e->getMessage());
            $errors = $reponse->errors;
            $refreshContact = isset($errors->subject_id) && $errors->subject_id[0] === 'Kontakt neexistuje.';
            if ($refreshContact === false) {
                throw $e;
            }
        }

        // if creating invoice fails on deleted subject, try to create again
        // with forced reloading subject from Fakturoid
        if ($refreshContact) {
            // create new invoice and force reload subject
            $this->processCreateInvoiceForOrder($order_id, true);
        }
    }

    /**
     * @param int $order_id
     * @param bool $forceReloadUserFromFakturoid
     * @throws ApplicationException|Exception
     */
    private function processCreateInvoiceForOrder($order_id, $forceReloadUserFromFakturoid = false)
    {
        // fetch order
        $order = $this->orders->findOrFail($order_id);

        // resolve Fakturoid user_id
        $fakturoid_user_id = $this->getFakturoidUserId($order, $forceReloadUserFromFakturoid);

        /** @var FakturoidInvoiceFactory $factory */
        $factory = app(FakturoidInvoiceFactory::class);

        // prepare invoice data
        $invoice_data = $factory->prepareInvoiceDataFromOrder($order, $fakturoid_user_id);

        // create Fakturoid invoice
        $fakturoid_invoice = $this->invoices->createInvoice($invoice_data);

        // create new local Invoice for Order
        $order->fakturoid_invoices()->create([
            'fakturoid_id' => $fakturoid_invoice->id,
            'fakturoid_number' => $fakturoid_invoice->number,
        ]);
    }

    /**
     * @param Order $order
     * @param bool $forceReloadFromFakturoid
     * @return int
     * @throws ApplicationException
     * @throws Exception
     */
    private function getFakturoidUserId(Order $order, $forceReloadFromFakturoid = false)
    {
        $user = $order->user;

        // if we have Fakturoid ID saved from previous calls, use it
        if (!empty($user->fakturoid_id) && $forceReloadFromFakturoid === false) {
            return $user->fakturoid_id;
        }

        // if Order has User
        if ($user !== null) {
            // get Fakturoid user
            $fakturoid_user = $this->findOrCreateRegisteredUser($order, $user);

            // save fakturoid_id for next use
            $user->fakturoid_id = $fakturoid_user->id;
            $user->save();

            return $fakturoid_user->id;
        }

        // if Order does not have User
        $fakturoid_user = $this->findOrCreateNonRegisteredUser($order);

        return $fakturoid_user->id;
    }

    /**
     * @param Order $order
     * @param User $user
     * @return stdClass
     * @throws Exception
     */
    private function findOrCreateRegisteredUser(Order $order, User $user)
    {
        // try to find user by email
        $fakturoid_users = $this->subjects->searchSubjects($user->email);
        if (!empty($fakturoid_users)) {
            return $fakturoid_users[0];
        }

        /** @var FakturoidUserFactory $factory */
        $factory = app(FakturoidUserFactory::class);
        $user_data = $factory->prepareUserDataFromOrderAndUser($order, $user);

        return $this->subjects->createSubject($user_data);
    }

    /**
     * @param Order $order
     * @return stdClass
     * @throws ApplicationException
     * @throws Exception
     */
    private function findOrCreateNonRegisteredUser(Order $order)
    {
        // without email, we are not able to create new user in Fakturoid (and check whether user is exists)
        if (empty($order->property['email'])) {
            throw new ApplicationException(
                'Order does not have email neither related user with email address. ' .
                'Unable to create new user in Fakturoid.'
            );
        }

        // try to find user by email
        $email = $order->property['email'];
        $fakturoid_users = $this->subjects->searchSubjects($email);
        if (!empty($fakturoid_users)) {
            return $fakturoid_users[0];
        }

        /** @var FakturoidUserFactory $factory */
        $factory = app(FakturoidUserFactory::class);
        $user_data = $factory->prepareUserDataFromOrder($order);

        return $this->subjects->createSubject($user_data);
    }
}
