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
    'client_id' => '1215086048524228',
    'client_secret' => 'cd31a14a3ad6d456c03406ff6d4b0e59',
    'redirect' => 'http://xtra.estatebaron.com/auth/facebook/callback',
    ],
    'linkedin' => [
    'client_id' => '754ylsamh53veh',
    'client_secret' => 'WkI3b34nx6eii7xz',
    'redirect' => 'http://estatebaron.com/auth/linkedin/callback',
    ],
    'twitter' => [
    'client_id' => 'rXLmiW1spxnHTmVq305ZJwTe9',
    'client_secret' => 'vXP4coQnehpHYJhbVRNCAYLhnVgSUE2qmRxWpbhVcvcEkwOBoc',
    'redirect' => 'http://estatebaron.com/auth/twitter/callback',
    ],
    'google' => [
    'client_id' => '124057571877-5er7hciotfl6i1pmlu1ajnofa5sh1o76.apps.googleusercontent.com',
    'client_secret' => 'o-allW730HIwLdLlpIkO7LE6',
    'redirect' => 'http://estatebaron.com/auth/google/callback',
    ],

];
