<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => '',
        'secret' => '',
    ],

    'facebook' => [
    'client_id' => '255756764800708',
    'client_secret' => '6cb850653967e7eeee5b13cadade0fd6',
    'redirect' => 'http://www.newdawnfund.com/auth/facebook/callback',
    ],
    'linkedin' => [
    'client_id' => '812v9uwe6qtx1q',
    'client_secret' => 'U07jt0Ldehk86Ori',
    'redirect' => 'http://www.newdawnfund.com/auth/linkedin/callback',
    ],
    'twitter' => [
    'client_id' => 'rXLmiW1spxnHTmVq305ZJwTe9',
    'client_secret' => 'vXP4coQnehpHYJhbVRNCAYLhnVgSUE2qmRxWpbhVcvcEkwOBoc',
    'redirect' => 'http://localhost:8000/auth/twitter/callback',
    ],
    'google' => [
    'client_id' => '187907114060-jlrn4atd499vopee68cpsfcvsckothq0.apps.googleusercontent.com',
    'client_secret' => '0h9akYIyxt6x027Efy9EO4iW',
    'redirect' => 'http://www.newdawnfund.com/auth/google/callback',
    ],

];
