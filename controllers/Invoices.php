<?php namespace VojtaSvoboda\ShopaholicFakturoid\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Symfony\Component\HttpFoundation\Response;
use VojtaSvoboda\ShopaholicFakturoid\Models\Invoice;
use VojtaSvoboda\ShopaholicFakturoid\Services\OrderService;

/**
 * Invoices Back-end Controller
 */
class Invoices extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.ListController',
    ];

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('VojtaSvoboda.Fakturoid', 'fakturoid', 'invoices');
    }

    /**
     * Donwload invoice's PDF.
     *
     * @param int $invoice_id
     * @return Response
     * @throws \Fakturoid\Exception
     */
    public function pdf($invoice_id)
    {
        // find invoice
        $invoice = Invoice::find($invoice_id);

        /** @var OrderService $service */
        $service = app(OrderService::class);
        $pdf = $service->getInvoicePdf($invoice->fakturoid_id);
        $number = $invoice->fakturoid_number;

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="faktura_' . $number . '.pdf"',
            'Content-Length' => strlen($pdf),
        ]);
    }
}
