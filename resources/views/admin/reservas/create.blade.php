<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Reserva - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-3xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Crear</p>
                <h1 class="text-2xl font-bold">Nueva reserva</h1>
            </div>
            <a href="{{ route('reservas.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
            <form action="{{ route('reservas.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-slate-700">Cancha</label>
                    <select name="cancha_id" required
                            class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        <option value="">Seleccione...</option>
                        @foreach($canchas as $id => $nombre)
                            <option value="{{ $id }}" @selected(old('cancha_id') == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                    @error('cancha_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Cliente</label>
                    <select name="cliente_id" required
                            class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        <option value="">Seleccione...</option>
                        @foreach($clientes as $id => $nombre)
                            <option value="{{ $id }}" @selected(old('cliente_id') == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                    @error('cliente_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Fecha</label>
                        <input type="date" name="fecha" value="{{ old('fecha') }}" required
                               class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        @error('fecha') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Hora de inicio</label>
                        <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required
                               class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        @error('hora_inicio') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Duración (horas)</label>
                        <input type="number" name="duracion_horas" min="1" value="{{ old('duracion_horas', 1) }}" required
                               class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        @error('duracion_horas') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Estado</label>
                        <select name="estado_id" required
                                class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                            <option value="">Seleccione...</option>
                            @foreach($estados as $id => $nombre)
                                <option value="{{ $id }}" @selected(old('estado_id') == $id)>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        @error('estado_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <p class="text-xs text-slate-500">El precio se calculará automáticamente al guardar (precio de la cancha x horas).</p>

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex w-full justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Guardar reserva
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
