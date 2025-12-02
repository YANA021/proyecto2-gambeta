<?php

return [

    /*
    |--------------------------------------------------------------------------
    | nombre de la aplicación
    |--------------------------------------------------------------------------
    |
    | este valor es el nombre de nuestra aplicación, que se usará cuando el
    | framework necesite colocar el nombre de la aplicación en una notificación u
    | otros elementos de la interfaz donde se deba mostrar el nombre de la aplicación.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | entorno de la aplicación
    |--------------------------------------------------------------------------
    |
    | este valor determina el "entorno" en el que se está ejecutando nuestra aplicación.
    | esto puede determinar cómo prefieres configurar varios servicios que utiliza
    | la aplicación. configurémoslo en nuestro archivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | modo de depuración de la aplicación
    |--------------------------------------------------------------------------
    |
    | cuando nuestra aplicación está en modo de depuración, se mostrarán mensajes de error
    | detallados con trazas de pila en cada error que ocurra dentro de nuestra
    | aplicación. si está deshabilitado, se muestra una página de error genérica simple.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | url de la aplicación
    |--------------------------------------------------------------------------
    |
    | esta url es utilizada por la consola para generar correctamente las urls al usar
    | la herramienta de línea de comandos artisan. debemos establecer esto en la raíz de
    | la aplicación para que esté disponible dentro de los comandos de artisan.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | zona horaria de la aplicación
    |--------------------------------------------------------------------------
    |
    | aquí podemos especificar la zona horaria predeterminada para nuestra aplicación, que
    | será utilizada por las funciones de fecha y hora de php. la zona horaria
    | se establece en "utc" por defecto ya que es adecuada para la mayoría de los casos de uso.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | configuración regional de la aplicación
    |--------------------------------------------------------------------------
    |
    | la configuración regional de la aplicación determina la configuración regional predeterminada que se utilizará
    | por los métodos de traducción / localización de laravel. esta opción puede ser
    | establecida en cualquier configuración regional para la que planees tener cadenas de traducción.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | clave de encriptación
    |--------------------------------------------------------------------------
    |
    | esta clave es utilizada por los servicios de encriptación de laravel y debe establecerse
    | en una cadena aleatoria de 32 caracteres para asegurar que todos los valores encriptados
    | sean seguros. debemos hacer esto antes de desplegar la aplicación.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | controlador de modo de mantenimiento
    |--------------------------------------------------------------------------
    |
    | estas opciones de configuración determinan el controlador utilizado para determinar y
    | gestionar el estado de "modo de mantenimiento" de laravel. el controlador "cache"
    | permitirá controlar el modo de mantenimiento a través de múltiples máquinas.
    |
    | controladores soportados: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
