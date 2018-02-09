<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Api Key
    |--------------------------------------------------------------------------
    |
    | Your application's API key. This key identifies your application for
    | purposes of quota management. Learn how to get a key from the APIs Console.
    */
   
    'app_id' => env('INTERCOM_APP_ID', 'DEFAULT'),

    'api_key' => env('INTERCOM_API_KEY', 'DEFAULT'),

    /*
    |--------------------------------------------------------------------------
    | Enable Intercom Analytics
    |--------------------------------------------------------------------------
    |
    | This defines if Intercom Analytics is enabled.
    |
    | Requires a valid Intercom Analytics Tracking ID.
    |
    | Default to false.
    |
    */

    'enable' => env('INTERCOM_ENABLE', false),
    

];
