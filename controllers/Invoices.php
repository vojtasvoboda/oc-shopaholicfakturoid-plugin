<?php namespace VojtaSvoboda\ShopaholicFakturoid\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

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
}
