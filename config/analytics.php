<?php

return [

        'gtm' => [
            /*
            |--------------------------------------------------------------------------
            | Enable Google Analytics
            |--------------------------------------------------------------------------
            | This defines if Google Analytics is enabled.
            | Requires a valid Google Analytics Tracking ID.
            | Default to false.
            */
            'enable' => env('GTM_ENABLE', false),
            /*
            |--------------------------------------------------------------------------
            | Google Analytics Tracking ID
            |--------------------------------------------------------------------------
            | This defines the Google Analytics Tracking ID to use.
            | Default to 'UA-XXXXXXXX-X'.
            */
            'id' => env('GTM_ID', 'UA-XXXXXXXX-X'),
        ],

];
