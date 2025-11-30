<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Roles</h1>
            <a href="{{ route('roles.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Nuevo Rol
            </a>
        </div>

        @if ($message = session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded">
                {{ $message }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="w-full text-left">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-6 py-3 font-semibold">ID</th>
                        <th class="px-6 py-3 font-semibold">Nombre</th>
                        <th class="px-6 py-3 font-semibold">Usuarios asignados</th>
                        <th class="px-6 py-3 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $rol)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $rol->id }}</td>
                            <td class="px-6 py-4 font-medium">{{ $rol->nombre }}</td>
                            <td class="px-6 py-4">{{ $rol->usuarios_count }}</td>
                            <td class="px-6 py-4 flex flex-wrap gap-2">
                                <a href="{{ route('roles.show', $rol) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-1 px-3 rounded">Ver</a>
                                <a href="{{ route('roles.edit', $rol) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold py-1 px-3 rounded">Editar</a>
                                <form action="{{ route('roles.destroy', $rol) }}" method="POST" class="inline-flex" onsubmit="return confirm('¿Seguro que deseas eliminar este rol?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-1 px-3 rounded">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No hay roles registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $roles->links() }}
        </div>
    </div>
</body>
</html>
