<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tipo de Cancha - Gambeta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Editar Tipo de Cancha</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tipo_canchas.update', $tipoCancha->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre</label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    class="w-full px-3 py-2 border border-gray-300 rounded @error('nombre') border-red-500 @enderror" 
                    placeholder="Ej. Fútbol, Basketball, Tenis" 
                    value="{{ old('nombre', $tipoCancha->nombre) }}"
                    required
                >
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Actualizar
                </button>
                <a href="{{ route('tipo_canchas.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                    Cancelar
                </a>
            </div>
        </form>
        </div>
    </div>
</body>
</html>