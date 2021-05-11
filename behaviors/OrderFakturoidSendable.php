<?php namespace VojtaSvoboda\ShopaholicFakturoid\Behaviors;

use Backend;
use Exception;
use Flash;
use October\Rain\Extension\ExtensionBase;
use Redirect;
use VojtaSvoboda\Fakturoid\Models\Settings;
use VojtaSvoboda\ShopaholicFakturoid\Services\OrderService;

class OrderFakturoidSendable extends ExtensionBase
{
    /**
     * @param int $order_id
     * @return Redirect
     */
    public function onFakturoidSend($order_id)
    {
        /** @var OrderService $service */
        $service = app(OrderService::class);

        // init
        $error = null;
        $redirect = Backend::url('lovata/ordersshopaholic/orders/update/' . $order_id . '?#primarytab-fakturoid');

        try {
            // create new invoice
            $service->createInvoiceForOrder($order_id);

        } catch (Exception $e) {
            $error = $e->getMessage();
            if (empty($error)) {
                $error = 'Neznámá chyba. Více info viz. Fakturoid > Log';
            }

            Flash::error($error);

            return Redirect::to($redirect);
        }

        // redirect to the orders list
        $toList = Settings::get('settings_redirect_to_list', false);
        if (!empty($toList) && empty($error)) {
            $redirect = Backend::url('lovata/ordersshopaholic/orders');
        }

        Flash::success('Objednávka úspěšné odeslána.');

        return Redirect::to($redirect);
    }
}
