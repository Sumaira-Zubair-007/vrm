<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

 $config = [

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | The environment on which the API host will be set up, the accepted values
    | are: sandbox, development and production.
    | https://plaid.com/docs/api/#api-host
    |
    */
    'environment' => 'sandbox',

    /*
    |--------------------------------------------------------------------------
    | Secret
    |--------------------------------------------------------------------------
    |
    | Private API key, here you need to add the respective secret key based on
    | the environment that is set up. This value can be found on your Plaid
    | account under the keys section.
    | https://plaid.com/docs/api/tokens/#token-endpoints
    |
    */
    'secret' => 'ea20628b1bf34b771ed75c7c68cff2',

    /*
    |--------------------------------------------------------------------------
    | Client Id
    |--------------------------------------------------------------------------
    |
    | The client id is an identifier for the Plaid account and can be found
    | on your Plaid account under the keys section. This value is always
    | the same, doesn't change based on environment.
    | https://plaid.com/docs/api/tokens/#token-endpoints
    |
    */
    'client_id' => '604cba104fa1190010e0e1b9',

    /*
    |--------------------------------------------------------------------------
    | Client Name
    |--------------------------------------------------------------------------
    |
    | The name of your application, as it should be displayed in Link.
    | https://plaid.com/docs/api/tokens/#token-endpoints
    |
    */
    'client_name' => 'STRIPE-PLAID',

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    |
    | The language that Link should be displayed in.
    | When using a Link customization, the language configured here must match the setting
    | in the customization, or the customization will not be applied.
    | Supported languages are: English ('en'), French ('fr'), Spanish ('es'), Dutch ('nl')
    | https://plaid.com/docs/api/tokens/#token-endpoints
    |
    */
    'language' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Country Codes
    |--------------------------------------------------------------------------
    |
    | Specify an array of Plaid-supported country codes using the ISO-3166-1 alpha-2 country code standard.
    | Note that if you initialize with a European country code, your users will see the European consent panel
    | during the Link flow.
    | If Link is launched with multiple country codes, only products that you are enabled for in all countries will be used by Link.
    | Supported country codes are: US, CA, ES, FR, GB, IE, NL. Example value: ['US', 'CA'].
    | https://plaid.com/docs/api/tokens/#token-endpoints
    |
    */
    'country_codes' => ['US'],

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    |
    | List of Plaid product(s) you wish to use. If launching Link in update mode,
    | should be omitted; required otherwise
    | Supported products are: transactions, auth, identity, assets, investments, liabilities, payment_initiation.
    | Example value: ['auth', 'transactions']
    | https://plaid.com/docs/api/tokens/#token-endpoints
    |
    */
    'products' => ['auth'],

];