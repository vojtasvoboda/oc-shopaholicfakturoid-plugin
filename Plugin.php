<?php namespace VojtaSvoboda\ShopaholicFakturoid;

use Backend;
use Backend\Widgets\Form;
use Event;
use File;
use Lovata\OrdersShopaholic\Controllers\Orders;
use Lovata\OrdersShopaholic\Models\Order;
use System\Classes\PluginBase;
use VojtaSvoboda\ShopaholicFakturoid\Models\Invoice;
use Yaml;

class Plugin extends PluginBase
{
    /** @var string[] $require Required plugins. */
    public $require = [
        'Lovata.OrdersShopaholic',
        'VojtaSvoboda.Fakturoid',
    ];

    /**
     * Boot method, called right before the request route.
     */
    public function boot()
    {
        // extend Lovata.OrdersShopaholic Orders controller
        Orders::extend(function ($controller) {
            // merge invoices relation with existing relations
            $invoicesRelationConfig = __DIR__ . '/config/lovata_ordersshopaholic_order_relations.yaml';
            $controller->relationConfig = $controller->mergeConfig(
                $controller->relationConfig,
                $invoicesRelationConfig
            );

            // add onFakturoidSend handler
            $controller->implement[] = 'VojtaSvoboda.ShopaholicFakturoid.Behaviors.OrderFakturoidSendable';
        });

        // extend Lovata.OrdersShopaholic Order model
        Order::extend(function ($model) {
            $model->hasMany['fakturoid_invoices'] = [
                Invoice::class,
                'table' => 'lovata_orders_shopaholic_order_fakturoid_invoices',
            ];
        });

        // extend Lovata.OrdersShopaholic Order form
        Event::listen('backend.form.extendFieldsBefore', function (Form $form) {
            // apply only to User model
            if (!$form->model instanceof Order) {
                return;
            }

            // add new fields
            $configFile = __DIR__ . '/config/lovata_ordersshopaholic_order_fields.yaml';
            $config = Yaml::parse(File::get($configFile));
            $form->tabs['fields'] += $config;
        });

        // extend VojtaSvoboda.Fakturoid side menu
        Event::listen('backend.menu.extendItems', function ($manager) {
            $manager->addSideMenuItem('VojtaSvoboda.Fakturoid', 'fakturoid', 'invoices', [
                'label' => 'Invoices',
                'url' => Backend::url('vojtasvoboda/shopaholicfakturoid/invoices'),
                'icon' => 'icon-list',
                'permissions' => ['vojtasvoboda.shopaholic_fakturoid.invoices'],
                'order' => 500,
            ]);
        });
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'vojtasvoboda.shopaholic_fakturoid.invoices' => [
                'tab' => 'Shopaholic Fakturoid',
                'label' => 'Fakturoid invoices',
            ],
        ];
    }
}
