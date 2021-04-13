<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Additional Property Keys.
    |--------------------------------------------------------------------------
    |
    | You can create Additional Order Properties at:
    | - CMS > Settings > Catalog configuration > Additional order properties.
    |
    */
    'additional_properties' => [
        // Additional Order Property key for company registration number
        'reg_no' => 'ico',

        // Additional Order Property key for company VAT number
        'vat_no' => 'dic',
    ],

    /*
    |--------------------------------------------------------------------------
    | Country codes.
    |--------------------------------------------------------------------------
    |
    | Mapping countries to their country codes. Country names are taken from
    | Shopaholic.Order billing_country property.
    |
    | !!! Use lowercase countries names !!!
    |
    */
    'country_codes' => [
        'česká republika' => 'CZ',
        'slovensko' => 'SK',
        'francie' => 'FR',
    ],

    /*
    |--------------------------------------------------------------------------
    | Country locales.
    |--------------------------------------------------------------------------
    |
    | Mapping countries to their locales. Country names are taken from
    | Shopaholic.Order billing_country property.
    |
    | !!! Use lowercase countries names !!!
    |
    */
    'locales' => [
        'česká republika' => 'cs',
        'slovensko' => 'sk',
        'francie' => 'fr',
    ],
];
