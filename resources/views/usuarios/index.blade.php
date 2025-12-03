<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Usuarios</h1>
            <a href="{{ route('usuarios.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Nuevo Usuario
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
                        <th class="px-6 py-3 font-semibold">Nombre de usuario</th>
                        <th class="px-6 py-3 font-semibold">Rol</th>
                        <th class="px-6 py-3 font-semibold">Creado</th>
                        <th class="px-6 py-3 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $usuario->nombre_usuario }}</td>
                            <td class="px-6 py-4">{{ $usuario->rol->nombre ?? ucfirst(\App\Models\Roles::DEFAULT_ROLE) }}</td>
                            <td class="px-6 py-4">{{ $usuario->created_at?->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 flex flex-wrap gap-2">
                                <a href="{{ route('usuarios.show', $usuario) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-1 px-3 rounded">Ver</a>
                                <a href="{{ route('usuarios.edit', $usuario) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold py-1 px-3 rounded">Editar</a>
                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="inline-flex" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
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
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $usuarios->links() }}
        </div>
    </div>
</body>
</html>
