<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'culqi' => [
        'api_key' => env('CULQI_API_KEY'),
        'secret_key' => env('CULQI_SECRET_KEY'),
        'api_url' => env('CULQI_API_URL', 'https://api.culqi.com/v2'),
        'webhook_secret' => env('CULQI_WEBHOOK_SECRET'),
    ],

    'payment_gateway' => [
        'webhook_secret' => env('PAYMENT_WEBHOOK_SECRET'),
    ],

    'niubiz' => [
        'merchant_id' => env('NIUBIZ_MERCHANT_ID'),
        'access_key' => env('NIUBIZ_ACCESS_KEY'),
        'api_url' => env('NIUBIZ_API_URL', 'https://apitestenv.vnforapps.com'),
    ],

    'mercadopago' => [
        'public_key' => env('MERCADOPAGO_PUBLIC_KEY'),
        'access_token' => env('MERCADOPAGO_ACCESS_TOKEN'),
    ],

];
