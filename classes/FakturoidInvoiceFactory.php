<?php namespace VojtaSvoboda\ShopaholicFakturoid\Classes;

use Lovata\OrdersShopaholic\Models\Order;

class FakturoidInvoiceFactory
{
    /**
     * @param Order $order
     * @param int $fakturoid_user_id
     * @return array
     */
    public function prepareInvoiceDataFromOrder(Order $order, $fakturoid_user_id)
    {
        // init
        $lines = [];

        // prepare order lines
        foreach ($order->order_position as $position) {
            $offer = $position->offer;
            $measure = $offer->measure;

            // calculate price without vat without any rounding to have prices as precisely as possible
            // because $position->price_without_tax_value is rounded to 2 decimal points
            $price_without_vat = ($position->price_with_tax_value * 100) / (100 + $position->tax_percent);

            $lines[] = [
                'name' => $offer->name,
                'quantity' => $position->quantity,
                'unit_name' => !empty($measure) ? $measure->code : null,
                'unit_price' => $price_without_vat,
                'unit_price_without_vat' => $price_without_vat,
                'unit_price_with_vat' => $position->price_with_tax_value,
                'vat_rate' => $position->tax_percent,
            ];
        }

        return [
            'custom_id' => $order->id,
            'subject_id' => $fakturoid_user_id,
            'currency' => !empty($order->currency) ? $order->currency->code : null,
            'payment_method' => !empty($order->payment_method) ? $order->payment_method->code : null,
            'lines' => $lines,
        ];
    }
}
