<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | almacén de caché predeterminado
    |--------------------------------------------------------------------------
    |
    | esta opción controla el almacén de caché predeterminado que será utilizado por el
    | framework. esta conexión se utiliza si no se especifica otra explícitamente
    | al ejecutar una operación de caché dentro de la aplicación.
    |
    */

    'default' => env('CACHE_STORE', 'database'),

    /*
    |--------------------------------------------------------------------------
    | almacenes de caché
    |--------------------------------------------------------------------------
    |
    | aquí podemos definir todos los "almacenes" de caché para nuestra aplicación, así
    | como sus controladores. incluso podemos definir múltiples almacenes para el
    | mismo controlador de caché para agrupar tipos de elementos almacenados en nuestras cachés.
    |
    | controladores soportados: "array", "database", "file", "memcached",
    |                           "redis", "dynamodb", "octane",
    |                           "failover", "null"
    |
    */

    'stores' => [

        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CACHE_CONNECTION'),
            'table' => env('DB_CACHE_TABLE', 'cache'),
            'lock_connection' => env('DB_CACHE_LOCK_CONNECTION'),
            'lock_table' => env('DB_CACHE_LOCK_TABLE'),
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/data'),
        ],

        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => env('REDIS_CACHE_CONNECTION', 'cache'),
            'lock_connection' => env('REDIS_CACHE_LOCK_CONNECTION', 'default'),
        ],

        'dynamodb' => [
            'driver' => 'dynamodb',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => env('DYNAMODB_ENDPOINT'),
        ],

        'octane' => [
            'driver' => 'octane',
        ],

        'failover' => [
            'driver' => 'failover',
            'stores' => [
                'database',
                'array',
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | prefijo de clave de caché
    |--------------------------------------------------------------------------
    |
    | al utilizar los almacenes de caché apc, database, memcached, redis y dynamodb,
    | puede haber otras aplicaciones utilizando la misma caché. por esa razón,
    | podemos prefijar cada clave de caché para evitar colisiones.
    |
    */

    'prefix' => env('CACHE_PREFIX', Str::slug((string) env('APP_NAME', 'laravel')).'-cache-'),

];
