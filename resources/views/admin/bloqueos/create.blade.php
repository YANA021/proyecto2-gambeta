<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Bloqueo - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-2xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Gestión</p>
                <h1 class="text-2xl font-bold">Crear Bloqueo de Horario</h1>
            </div>
            <a href="{{ route('bloqueos.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
            <form action="{{ route('bloqueos.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Cancha</label>
                    <select name="cancha_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none" required>
                        <option value="">Seleccione una cancha...</option>
                        @foreach($canchas as $cancha)
                            <option value="{{ $cancha->id }}">{{ $cancha->nombre }}</option>
                        @endforeach
                    </select>
                    @error('cancha_id') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Fecha</label>
                    <input type="date" name="fecha" min="{{ now()->format('Y-m-d') }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none" required>
                    @error('fecha') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Hora Inicio</label>
                        <input type="time" name="hora_inicio" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none" required>
                        @error('hora_inicio') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Hora Fin</label>
                        <input type="time" name="hora_fin" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none" required>
                        @error('hora_fin') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Motivo</label>
                    <select name="motivo" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none" required>
                        <option value="Mantenimiento">Mantenimiento</option>
                        <option value="Evento Especial">Evento Especial</option>
                        <option value="Reparación">Reparación</option>
                        <option value="Reservado">Reservado</option>
                        <option value="Otro">Otro</option>
                    </select>
                    @error('motivo') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="mt-4 w-full rounded-lg bg-rose-600 py-2.5 font-bold text-white hover:bg-rose-700">
                    🚫 Crear Bloqueo
                </button>
            </form>
        </div>
    </div>
</body>
</html>
