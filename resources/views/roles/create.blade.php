<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Rol - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-lg mx-auto bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Crear Rol</h1>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('roles.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre</label>
                    <select
                        id="nombre"
                        name="nombre"
                        class="w-full border border-gray-300 rounded px-3 py-2 @error('nombre') border-red-500 @enderror"
                        required
                    >
                        <option value="">Seleccione un rol</option>
                        @foreach($permittedRoles as $roleName)
                            <option value="{{ $roleName }}" @selected(old('nombre') === $roleName)>
                                {{ ucfirst($roleName) }}
                            </option>
                        @endforeach
                    </select>
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                        Guardar
                    </button>
                    <a href="{{ route('roles.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
