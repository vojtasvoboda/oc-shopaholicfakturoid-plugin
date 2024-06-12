<?php

return [

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
        // European countries
        'al' => 'AL', // Albania
        'ad' => 'AD', // Andorra
        'at' => 'AT', // Austria
        'by' => 'BY', // Belarus
        'be' => 'BE', // Belgium
        'ba' => 'BA', // Bosnia and Herzegovina
        'bg' => 'BG', // Bulgaria
        'hr' => 'HR', // Croatia
        'cy' => 'CY', // Cyprus
        'cz' => 'CZ', // Czech Republic
        'dk' => 'DK', // Denmark
        'ee' => 'EE', // Estonia
        'fi' => 'FI', // Finland
        'fr' => 'FR', // France
        'ge' => 'GE', // Georgia
        'de' => 'DE', // Germany
        'gr' => 'GR', // Greece
        'hu' => 'HU', // Hungary
        'is' => 'IS', // Iceland
        'ie' => 'IE', // Ireland
        'it' => 'IT', // Italy
        'lv' => 'LV', // Latvia
        'li' => 'LI', // Liechtenstein
        'lt' => 'LT', // Lithuania
        'lu' => 'LU', // Luxembourg
        'mt' => 'MT', // Malta
        'md' => 'MD', // Moldova
        'mc' => 'MC', // Monaco
        'me' => 'ME', // Montenegro
        'nl' => 'NL', // Netherlands
        'mk' => 'MK', // North Macedonia
        'no' => 'NO', // Norway
        'pl' => 'PL', // Poland
        'pt' => 'PT', // Portugal
        'ro' => 'RO', // Romania
        'ru' => 'RU', // Russia
        'sm' => 'SM', // San Marino
        'rs' => 'RS', // Serbia
        'sk' => 'SK', // Slovakia
        'si' => 'SI', // Slovenia
        'es' => 'ES', // Spain
        'se' => 'SE', // Sweden
        'ch' => 'CH', // Switzerland
        'ua' => 'UA', // Ukraine
        'gb' => 'GB', // United Kingdom
        'va' => 'VA', // Vatican City

        // Significant countries outside Europe
        'us' => 'US', // United States
        'ca' => 'CA', // Canada
        'au' => 'AU', // Australia
        'nz' => 'NZ', // New Zealand
        'br' => 'BR', // Brazil
        'ar' => 'AR', // Argentina
        'mx' => 'MX', // Mexico
        'cn' => 'CN', // China
        'in' => 'IN', // India
        'jp' => 'JP', // Japan
        'kr' => 'KR', // South Korea
        'sg' => 'SG', // Singapore
        'my' => 'MY', // Malaysia
        'th' => 'TH', // Thailand
        'vn' => 'VN', // Vietnam
        'id' => 'ID', // Indonesia
        'ph' => 'PH', // Philippines
        'sa' => 'SA', // Saudi Arabia
        'ae' => 'AE', // United Arab Emirates
        'il' => 'IL', // Israel
        'eg' => 'EG', // Egypt
        'za' => 'ZA', // South Africa
        'ng' => 'NG', // Nigeria
        'ke' => 'KE', // Kenya
        'tz' => 'TZ', // Tanzania
        'gh' => 'GH', // Ghana
        'dz' => 'DZ', // Algeria
        'ma' => 'MA', // Morocco
        'tr' => 'TR', // Turkey
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
        'cz' => 'cz',
        'fr' => 'fr',
        'us' => 'en',
        'de' => 'de',
        'it' => 'it',
        'es' => 'es',
        'ru' => 'ru',
        'cn' => 'en',
        'jp' => 'en',
        'kr' => 'en',
        'br' => 'en',
        'in' => 'en',
        'sa' => 'en',
        'nl' => 'en',
        'se' => 'en',
        'no' => 'en',
        'fi' => 'en',
        'dk' => 'en',
        'pl' => 'pl',
        'hu' => 'hu',
        'gr' => 'en',
        'tr' => 'en',
        'il' => 'en',
        'ir' => 'en',
        'th' => 'en',
        'vn' => 'en',
        'id' => 'en',
        'my' => 'en',
        'ua' => 'en',
        'ro' => 'ro',
        'bg' => 'en',
        'hr' => 'en',
        'sk' => 'sk',
        'si' => 'en',
        'lt' => 'en',
        'lv' => 'en',
        'ee' => 'en',
        'at' => 'de', // Austria
        'be' => 'fr', // Belgium (French)
        'cy' => 'en', // Cyprus (Greek)
        'ie' => 'en', // Ireland (English)
        'lu' => 'fr', // Luxembourg (French)
        'mt' => 'en', // Malta (Maltese)
        'pt' => 'en', // Portugal (Portuguese)
    ],


    /*
    |--------------------------------------------------------------------------
    | Country footer notes.
    |--------------------------------------------------------------------------
    |
    | Mapping footer notes on country.
    | If the country code is not mapped, the default settings from the fakturoid administration are used.
    |
    | !!! Use lowercase countries names !!!
    |
    */
    'country_footer_notes' => [
        /*'cz' => 'Footer specifically for the Czech Republic.',
        'sk' => 'Footer specially for Slovakia',
        'de' => 'Footer specially for Germany',*/
    ],

    /*
    |--------------------------------------------------------------------------
    | Paid Status
    |--------------------------------------------------------------------------
    |
    | Mapping paid status from administration for: ALREADY PAID display in invoice
    |
    | !!! Use status code property from adminisitration !!!
    |
    */
    'is_paid_statuses' => [
        'paid',
        'paid_with_card'
    ],
];
