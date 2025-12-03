<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva #{{ $reserva->id }} - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-4xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between gap-3">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Detalle</p>
                <h1 class="text-2xl font-bold">Reserva #{{ $reserva->id }}</h1>
            </div>
            <a href="{{ route('reservas.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm space-y-4">
            <div>
                <p class="text-sm text-slate-500">Cancha</p>
                <p class="text-lg font-semibold text-slate-900">{{ $reserva->cancha->nombre ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Cliente</p>
                <p class="font-semibold">{{ $reserva->cliente->nombre ?? '—' }}</p>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-slate-500">Fecha</p>
                    <p class="font-semibold">{{ optional($reserva->fecha)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Hora inicio</p>
                    <p class="font-semibold">{{ $reserva->hora_inicio }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-slate-500">Duración</p>
                    <p class="font-semibold">{{ $reserva->duracion_horas }} h</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Estado</p>
                    <p class="font-semibold">{{ $reserva->estado->nombre ?? '—' }}</p>
                </div>
            </div>
            <div>
                <p class="text-sm text-slate-500">Precio total</p>
                <p class="text-lg font-semibold text-slate-900">${{ number_format($reserva->precio_total, 2) }}</p>
            </div>

            <div class="flex flex-wrap gap-3 text-sm font-semibold pt-2">
                <a href="{{ route('reservas.edit', $reserva) }}"
                   class="rounded-lg bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">Editar</a>
                @if(auth()->user()->hasRole('administrador'))
                    <form action="{{ route('reservas.destroy', $reserva) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar esta reserva?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-lg bg-rose-500 px-4 py-2 text-white hover:bg-rose-600">
                            Eliminar
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
