<?php

return [

    /*
    |--------------------------------------------------------------------------
    | remitente de correo predeterminado
    |--------------------------------------------------------------------------
    |
    | esta opción controla el remitente de correo predeterminado que se utiliza para enviar todos los mensajes
    | de correo electrónico a menos que se especifique otro remitente explícitamente al enviar
    | el mensaje. todos los remitentes adicionales se pueden configurar dentro del
    | array "mailers". se proporcionan ejemplos de cada tipo de remitente.
    |
    */

    'default' => env('MAIL_MAILER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | configuraciones de remitentes
    |--------------------------------------------------------------------------
    |
    | aquí podemos configurar todos los remitentes utilizados por nuestra aplicación más
    | sus configuraciones. se han configurado varios ejemplos para
    | nosotros y somos libres de añadir los nuestros propios según lo requiera nuestra aplicación.
    |
    | laravel soporta una variedad de controladores de "transporte" de correo que se pueden usar
    | al entregar un correo electrónico. podemos especificar cuál estamos usando para
    | nuestros remitentes a continuación. también podemos añadir remitentes adicionales si es necesario.
    |
    | soportado: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "resend", "log", "array",
    |            "failover", "roundrobin"
    |
    */

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 2525),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
            'retry_after' => 60,
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
            'retry_after' => 60,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | dirección "de" global
    |--------------------------------------------------------------------------
    |
    | es posible que deseemos que todos los correos electrónicos enviados por nuestra aplicación se envíen desde
    | la misma dirección. aquí podemos especificar un nombre y una dirección que se
    | utiliza globalmente para todos los correos electrónicos que son enviados por nuestra aplicación.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

];
