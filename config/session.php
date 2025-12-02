<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | controlador de sesión predeterminado
    |--------------------------------------------------------------------------
    |
    | esta opción determina el controlador de sesión predeterminado que se utiliza para
    | las solicitudes entrantes. laravel soporta una variedad de opciones de almacenamiento para
    | persistir datos de sesión. el almacenamiento en base de datos es una excelente opción predeterminada.
    |
    | soportado: "file", "cookie", "database", "memcached",
    |            "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | tiempo de vida de la sesión
    |--------------------------------------------------------------------------
    |
    | aquí podemos especificar el número de minutos que deseamos permitir que la sesión
    | permanezca inactiva antes de que expire. si queremos que expiren
    | inmediatamente cuando se cierre el navegador, entonces podemos
    | indicarlo a través de la opción de configuración expire_on_close.
    |
    */

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | encriptación de sesión
    |--------------------------------------------------------------------------
    |
    | esta opción nos permite especificar fácilmente que todos nuestros datos de sesión
    | deben ser encriptados antes de ser almacenados. toda la encriptación se ejecuta
    | automáticamente por laravel y podemos usar la sesión como de costumbre.
    |
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | ubicación del archivo de sesión
    |--------------------------------------------------------------------------
    |
    | al utilizar el controlador de sesión "file", los archivos de sesión se colocan
    | en el disco. la ubicación de almacenamiento predeterminada se define aquí; sin embargo,
    | eres libre de proporcionar otra ubicación donde deban almacenarse.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | conexión de base de datos de sesión
    |--------------------------------------------------------------------------
    |
    | al usar los controladores de sesión "database" o "redis", podemos especificar una
    | conexión que debe usarse para gestionar estas sesiones. esto debe
    | corresponder a una conexión en nuestras opciones de configuración de base de datos.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | tabla de base de datos de sesión
    |--------------------------------------------------------------------------
    |
    | al usar el controlador de sesión "database", podemos especificar la tabla que se
    | debe usar para gestionar las sesiones. se ha incluido un ejemplo
    | para nosotros; sin embargo, podemos cambiar esto a otra tabla.
    |
    */

    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | almacén de caché de sesión
    |--------------------------------------------------------------------------
    |
    | al usar uno de los backends de sesión impulsados por caché del framework, podemos
    | definir el almacén de caché que debe usarse para almacenar los datos de sesión
    | entre solicitudes. esto debe coincidir con uno de tus almacenes de caché definidos.
    |
    | afecta: "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | lotería de limpieza de sesión
    |--------------------------------------------------------------------------
    |
    | algunos controladores de sesión deben limpiar manualmente su ubicación de almacenamiento para
    | deshacerse de las sesiones antiguas del almacenamiento. aquí están las probabilidades de que
    | suceda en una solicitud dada. por defecto, las probabilidades son 2 de 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | nombre de cookie de sesión
    |--------------------------------------------------------------------------
    |
    | aquí puedes cambiar el nombre de la cookie de sesión que crea el
    | framework. típicamente, no deberías necesitar cambiar este valor
    | ya que hacerlo no otorga una mejora de seguridad significativa.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')).'-session'
    ),

    /*
    |--------------------------------------------------------------------------
    | ruta de cookie de sesión
    |--------------------------------------------------------------------------
    |
    | la ruta de la cookie de sesión determina la ruta para la cual la cookie será
    | considerada como disponible. típicamente, esta será la ruta raíz de
    | tu aplicación, pero eres libre de cambiar esto cuando sea necesario.
    |
    */

    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | dominio de cookie de sesión
    |--------------------------------------------------------------------------
    |
    | este valor determina el dominio y subdominios a los que la cookie de sesión está
    | disponible. por defecto, la cookie estará disponible para el dominio raíz
    | y todos los subdominios. típicamente, esto no debería cambiarse.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | cookies solo https
    |--------------------------------------------------------------------------
    |
    | al establecer esta opción en true, las cookies de sesión solo se enviarán de vuelta
    | al servidor si el navegador tiene una conexión https. esto evitará que
    | la cookie se te envíe cuando no se pueda hacer de forma segura.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | solo acceso http
    |--------------------------------------------------------------------------
    |
    | establecer este valor en true evitará que javascript acceda al
    | valor de la cookie y la cookie solo será accesible a través del
    | protocolo http. es poco probable que debas deshabilitar esta opción.
    |
    */

    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | cookies del mismo sitio
    |--------------------------------------------------------------------------
    |
    | esta opción determina cómo se comportan tus cookies cuando tienen lugar solicitudes
    | entre sitios, y se puede usar para mitigar ataques csrf. por defecto,
    | estableceremos este valor en "lax" para permitir solicitudes seguras entre sitios.
    |
    | ver: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#samesitesamesite-value
    |
    | soportado: "lax", "strict", "none", null
    |
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | cookies particionadas
    |--------------------------------------------------------------------------
    |
    | establecer este valor en true vinculará la cookie al sitio de nivel superior para
    | un contexto entre sitios. las cookies particionadas son aceptadas por el navegador
    | cuando se marcan como "secure" y el atributo same-site se establece en "none".
    |
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
