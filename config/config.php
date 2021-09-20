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
		'česká republika' => 'Footer specifically for the Czech Republic.',
		'slovensko' => 'Footer specially for Slovakia',
		'francie' => 'Footer specially for France',
	],
];
