<?php

return [

    /*
    |--------------------------------------------------------------------------
    | nombre de conexión de cola predeterminado
    |--------------------------------------------------------------------------
    |
    | la cola de laravel soporta una variedad de backends a través de una api única y
    | unificada, dándonos acceso conveniente a cada backend usando una sintaxis
    | idéntica para cada uno. la conexión de cola predeterminada se define a continuación
    |
    */

    'default' => env('QUEUE_CONNECTION', 'database'),

    /*
    |--------------------------------------------------------------------------
    | conexiones de cola
    |--------------------------------------------------------------------------
    |
    | aquí podemos configurar las opciones de conexión para cada backend de cola
    | utilizado por nuestra aplicación. se proporciona una configuración de ejemplo para
    | cada backend soportado por laravel. también podemos añadir más
    |
    | controladores: "sync", "database", "beanstalkd", "sqs", "redis",
    |                "deferred", "background", "failover", "null"
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'connection' => env('DB_QUEUE_CONNECTION'),
            'table' => env('DB_QUEUE_TABLE', 'jobs'),
            'queue' => env('DB_QUEUE', 'default'),
            'retry_after' => (int) env('DB_QUEUE_RETRY_AFTER', 90),
            'after_commit' => false,
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => env('BEANSTALKD_QUEUE_HOST', 'localhost'),
            'queue' => env('BEANSTALKD_QUEUE', 'default'),
            'retry_after' => (int) env('BEANSTALKD_QUEUE_RETRY_AFTER', 90),
            'block_for' => 0,
            'after_commit' => false,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'default'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'after_commit' => false,
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => (int) env('REDIS_QUEUE_RETRY_AFTER', 90),
            'block_for' => null,
            'after_commit' => false,
        ],

        'deferred' => [
            'driver' => 'deferred',
        ],

        'background' => [
            'driver' => 'background',
        ],

        'failover' => [
            'driver' => 'failover',
            'connections' => [
                'database',
                'deferred',
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | procesamiento por lotes de trabajos
    |--------------------------------------------------------------------------
    |
    | las siguientes opciones configuran la base de datos y la tabla que almacenan la información
    | de procesamiento por lotes de trabajos. estas opciones se pueden actualizar a cualquier conexión
    | de base de datos y tabla que haya sido definida por nuestra aplicación
    |
    */

    'batching' => [
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'job_batches',
    ],

    /*
    |--------------------------------------------------------------------------
    | trabajos de cola fallidos
    |--------------------------------------------------------------------------
    |
    | estas opciones configuran el comportamiento del registro de trabajos de cola fallidos para que
    | podamos controlar cómo y dónde se almacenan los trabajos fallidos. laravel viene con
    | soporte para almacenar trabajos fallidos en un archivo simple o en una base de datos
    |
    | controladores soportados: "database-uuids", "dynamodb", "file", "null"
    |
    */

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'sqlite'),
        'table' => 'failed_jobs',
    ],

];
