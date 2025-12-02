<?php

return [

    /*
    |--------------------------------------------------------------------------
    | servicios de terceros
    |--------------------------------------------------------------------------
    |
    | este archivo es para almacenar las credenciales de servicios de terceros tales
    | como mailgun, postmark, aws y más. este archivo proporciona la ubicación
    | de facto para este tipo de información, permitiendo que los paquetes tengan
    | un archivo convencional para localizar las diversas credenciales de servicio.
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

];
