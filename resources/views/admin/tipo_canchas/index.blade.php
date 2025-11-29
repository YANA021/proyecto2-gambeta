<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos de Canchas - Gambeta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Tipos de Canchas</h1>
        <a href="{{ route('tipo_canchas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Crear Nuevo
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ $message }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 font-bold">ID</th>
                    <th class="px-6 py-3 font-bold">Nombre</th>
                    <th class="px-6 py-3 font-bold">Fecha de Creación</th>
                    <th class="px-6 py-3 font-bold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tiposCanchas as $tipoCancha)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $tipoCancha->id }}</td>
                        <td class="px-6 py-4">{{ $tipoCancha->nombre }}</td>
                        <td class="px-6 py-4">{{ $tipoCancha->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('tipo_canchas.show', $tipoCancha->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    Ver
                                </a>
                                <a href="{{ route('tipo_canchas.edit', $tipoCancha->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    Editar
                                </a>
                                <form action="{{ route('tipo_canchas.destroy', $tipoCancha->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de que desea eliminar este tipo de cancha?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Eliminar
                                    </button>
                                </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No hay tipos de canchas registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
</body>
</html>