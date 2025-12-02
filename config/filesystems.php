<?php

return [

    /*
    |--------------------------------------------------------------------------
    | disco de sistema de archivos predeterminado
    |--------------------------------------------------------------------------
    |
    | aquí podemos especificar el disco de sistema de archivos predeterminado que debe ser utilizado
    | por el framework. el disco "local", así como una variedad de discos basados en la nube
    | están disponibles para nuestra aplicación para el almacenamiento de archivos.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | discos de sistema de archivos
    |--------------------------------------------------------------------------
    |
    | a continuación podemos configurar tantos discos de sistema de archivos como sea necesario, y
    | podemos incluso configurar múltiples discos para el mismo controlador. ejemplos para
    | la mayoría de los controladores de almacenamiento soportados se configuran aquí como referencia.
    |
    | controladores soportados: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | enlaces simbólicos
    |--------------------------------------------------------------------------
    |
    | aquí podemos configurar los enlaces simbólicos que se crearán cuando se ejecute el
    | comando artisan `storage:link`. las claves del array deben ser
    | las ubicaciones de los enlaces y los valores deben ser sus destinos.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
