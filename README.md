# Shopaholic Fakturoid connector plugin for OctoberCMS

This plugin will allow you to send Shopaholic order to the Fakturoid invoicing system.

Tested and developed with OctoberCMS v1.1.4 (Laravel 6.0).

## Requirements

Require VojtaSvoboda.Fakturoid plugin and Lovata.OrdersShopaholic plugins.

## Using

After installing, you will see a new tab Fakturoid in Shopaholic order detail with a list of all attached Fakturoid
invoices and button which allows you to send an order to the Fakturoid and create a new Fakturoid invoice.

### Available payment methods

When creating new Payment Methods, don't forget to select Fakturoid type from this list:

- bank (bankovní převod)
- cash (hotově)
- cod (dobírka)
- paypal (PayPal)
- card (Karta)

You can set it in new Fakturoid tab in Payment Method detail.

See: https://fakturoid.docs.apiary.io/#reference/invoices

## Creating invoice

![Creating Invoice](/assets/images/schema.jpg)

## Contributing

Please send Pull Request to the master branch.

## License

Fakturoid plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT) same as
OctoberCMS platform.
