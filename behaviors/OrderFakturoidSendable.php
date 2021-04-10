<?php namespace VojtaSvoboda\ShopaholicFakturoid\Behaviors;

use Exception;
use Flash;
use October\Rain\Extension\ExtensionBase;
use VojtaSvoboda\ShopaholicFakturoid\Services\OrderService;

class OrderFakturoidSendable extends ExtensionBase
{
    /**
     * @param int $order_id
     */
    public function onFakturoidSend($order_id)
    {
        /** @var OrderService $service */
        $service = app(OrderService::class);

        try {
            // create new invoice
            $service->createInvoiceForOrder($order_id);

        } catch (Exception $e) {
            Flash::error($e->getMessage());
        }
    }
}
