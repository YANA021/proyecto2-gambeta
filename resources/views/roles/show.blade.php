<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Rol - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Detalle del Rol</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-gray-600 font-semibold">ID</p>
                    <p class="text-lg">{{ $role->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Nombre</p>
                    <p class="text-lg">{{ $role->nombre }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Fecha de creación</p>
                    <p class="text-lg">{{ $role->created_at?->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-semibold">Última actualización</p>
                    <p class="text-lg">{{ $role->updated_at?->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-3">Usuarios asociados</h2>
                @if($role->usuarios->isEmpty())
                    <p class="text-gray-500">Aún no hay usuarios con este rol.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($role->usuarios as $usuario)
                            <li class="py-2">
                                {{ $usuario->nombre_usuario ?? $usuario->name ?? $usuario->email ?? 'Usuario sin nombre' }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="flex gap-2">
                <a href="{{ route('roles.edit', $role) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded text-center">
                    Editar
                </a>
                <a href="{{ route('roles.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded text-center">
                    Volver
                </a>
            </div>
        </div>
    </div>
</body>
</html>
