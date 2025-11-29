<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Tipo de Cancha - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Detalle del Tipo de Cancha</h1>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">ID</label>
            <p class="text-gray-600">{{ $tipoCancha->id }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nombre</label>
            <p class="text-gray-600">{{ $tipoCancha->nombre }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Fecha de Creación</label>
            <p class="text-gray-600">{{ $tipoCancha->created_at->format('d/m/Y H:i:s') }}</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Última Actualización</label>
            <p class="text-gray-600">{{ $tipoCancha->updated_at->format('d/m/Y H:i:s') }}</p>
        </div>

        <div class="flex gap-2">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('tipo_canchas.edit', $tipoCancha->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center">
                    Editar
                </a>
            @endif
            <a href="{{ route('tipo_canchas.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                Volver
            </a>
        </div>
    </div>
</body>
</html>
