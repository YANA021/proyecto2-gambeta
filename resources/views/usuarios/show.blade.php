<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Usuario - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Detalle del Usuario</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-gray-600 font-semibold">ID</p>
                    <p class="text-lg">{{ $usuario->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Nombre de usuario</p>
                    <p class="text-lg">{{ $usuario->nombre_usuario }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Rol</p>
                    <p class="text-lg">{{ $usuario->rol->nombre ?? ucfirst(\App\Models\Roles::DEFAULT_ROLE) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Empleado</p>
                    <p class="text-lg">{{ $usuario->empleado->name ?? 'Sin asignar' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Creado el</p>
                    <p class="text-lg">{{ $usuario->created_at?->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Actualizado el</p>
                    <p class="text-lg">{{ $usuario->updated_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('usuarios.edit', $usuario) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded text-center">
                    Editar
                </a>
                <a href="{{ route('usuarios.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded text-center">
                    Volver
                </a>
            </div>
        </div>
    </div>
</body>
</html>
