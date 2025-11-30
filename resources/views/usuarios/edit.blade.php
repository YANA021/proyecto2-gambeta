<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Editar Usuario</h1>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="nombre_usuario" class="block text-gray-700 font-semibold mb-2">Nombre de usuario</label>
                    <input
                        type="text"
                        id="nombre_usuario"
                        name="nombre_usuario"
                        value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 @error('nombre_usuario') border-red-500 @enderror"
                        required
                    >
                    @error('nombre_usuario')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contrasena" class="block text-gray-700 font-semibold mb-2">Contraseña</label>
                    <input
                        type="password"
                        id="contrasena"
                        name="contrasena"
                        class="w-full border border-gray-300 rounded px-3 py-2 @error('contrasena') border-red-500 @enderror"
                        placeholder="Dejar en blanco para mantener la actual"
                    >
                    @error('contrasena')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="empleado_id" class="block text-gray-700 font-semibold mb-2">Empleado</label>
                        <select
                            id="empleado_id"
                            name="empleado_id"
                            class="w-full border border-gray-300 rounded px-3 py-2 @error('empleado_id') border-red-500 @enderror"
                        >
                            <option value="">Sin asignar</option>
                            @foreach($empleados as $id => $nombre)
                                <option value="{{ $id }}" @selected(old('empleado_id', $usuario->empleado_id) == $id)>
                                    {{ $nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('empleado_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rol_id" class="block text-gray-700 font-semibold mb-2">Rol</label>
                        <select
                            id="rol_id"
                            name="rol_id"
                            class="w-full border border-gray-300 rounded px-3 py-2 @error('rol_id') border-red-500 @enderror"
                        >
                            <option value="">Asignar automáticamente ({{ \App\Models\Roles::DEFAULT_ROLE }})</option>
                            @foreach($roles as $id => $nombre)
                                <option value="{{ $id }}" @selected(old('rol_id', $usuario->rol_id) == $id)>
                                    {{ ucfirst($nombre) }}
                                </option>
                            @endforeach
                        </select>
                        @error('rol_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                        Actualizar
                    </button>
                    <a href="{{ route('usuarios.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
