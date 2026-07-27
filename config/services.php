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
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
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

    'vexere' => [
        'oauth_url' => env('VEXERE_OAUTH_URL', 'https://account-service.nhaxenhatduong.com/v1/oauth/token'),
        'route_url' => env('VEXERE_ROUTE_URL', 'https://vroute.nhaxenhatduong.com/v2/route'),
        'client_id' => env('VEXERE_CLIENT_ID'),
        'client_secret' => env('VEXERE_CLIENT_SECRET'),
        'company_id' => env('VEXERE_COMPANY_ID', 39221),
        'areas' => [
            'TP. Hồ Chí Minh' => 29,
            'Nha Trang' => 417,
            'Cam Ranh' => 32,
        ],
    ],

];
