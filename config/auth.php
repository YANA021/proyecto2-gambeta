<?php

return [

    /*
    |--------------------------------------------------------------------------
    | valores predeterminados de autenticación
    |--------------------------------------------------------------------------
    |
    | esta opción define el "guardia" de autenticación predeterminado y el "broker"
    | de restablecimiento de contraseña para nuestra aplicación. podemos cambiar estos valores
    | según sea necesario, pero son un comienzo perfecto para la mayoría de las aplicaciones.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | guardias de autenticación
    |--------------------------------------------------------------------------
    |
    | a continuación, podemos definir cada guardia de autenticación para nuestra aplicación.
    | por supuesto, se ha definido una excelente configuración predeterminada para nosotros
    | que utiliza almacenamiento de sesión más el proveedor de usuarios eloquent.
    |
    | todos los guardias de autenticación tienen un proveedor de usuarios, que define cómo
    | los usuarios son realmente recuperados de nuestra base de datos u otro sistema de almacenamiento
    | utilizado por la aplicación. típicamente, se utiliza eloquent.
    |
    | soportado: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | proveedores de usuarios
    |--------------------------------------------------------------------------
    |
    | todos los guardias de autenticación tienen un proveedor de usuarios, que define cómo
    | los usuarios son realmente recuperados de nuestra base de datos u otro sistema de almacenamiento
    | utilizado por la aplicación. típicamente, se utiliza eloquent.
    |
    | si tenemos múltiples tablas o modelos de usuarios, podemos configurar múltiples
    | proveedores para representar el modelo / tabla. estos proveedores pueden ser
    | asignados a cualquier guardia de autenticación extra que hayas definido.
    |
    | soportado: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\Usuario::class),
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | restablecimiento de contraseñas
    |--------------------------------------------------------------------------
    |
    | estas opciones de configuración especifican el comportamiento de la funcionalidad
    | de restablecimiento de contraseña de laravel, incluyendo la tabla utilizada para
    | el almacenamiento de tokens y el proveedor de usuarios que se invoca para recuperar usuarios.
    |
    | el tiempo de expiración es el número de minutos que cada token de restablecimiento será
    | considerado válido. esta característica de seguridad mantiene los tokens de corta duración para que
    | tengan menos tiempo para ser adivinados. podemos cambiar esto según sea necesario.
    |
    | la configuración de limitación es el número de segundos que un usuario debe esperar antes
    | de generar más tokens de restablecimiento de contraseña. esto evita que el usuario
    | genere rápidamente una gran cantidad de tokens de restablecimiento de contraseña.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | tiempo de espera de confirmación de contraseña
    |--------------------------------------------------------------------------
    |
    | aquí podemos definir el número de segundos antes de que expire una ventana de confirmación
    | de contraseña y se pida a los usuarios que vuelvan a introducir su contraseña a través de
    | la pantalla de confirmación. por defecto, el tiempo de espera dura tres horas.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
