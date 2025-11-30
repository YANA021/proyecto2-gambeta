<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Estado de Reserva - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-3xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Crear</p>
                <h1 class="text-2xl font-bold">Nuevo estado</h1>
            </div>
            <a href="{{ route('estados_reserva.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
            <form action="{{ route('estados_reserva.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-slate-700">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required
                           class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none"
                           placeholder="Ej. pendiente">
                    @error('nombre') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex w-full justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Guardar estado
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
