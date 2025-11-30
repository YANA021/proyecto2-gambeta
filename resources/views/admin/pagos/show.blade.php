<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago #{{ $pago->id }} - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-4xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between gap-3">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Detalle</p>
                <h1 class="text-2xl font-bold">Pago #{{ $pago->id }}</h1>
            </div>
            <a href="{{ route('pagos.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm space-y-4">
            <div>
                <p class="text-sm text-slate-500">Reserva</p>
                <p class="text-lg font-semibold text-slate-900">#{{ $pago->reserva_id }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Cliente</p>
                <p class="font-semibold">{{ $pago->cliente->nombre ?? '—' }}</p>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-slate-500">Fecha de pago</p>
                    <p class="font-semibold">{{ optional($pago->fecha_pago)->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Monto</p>
                    <p class="font-semibold">${{ number_format($pago->monto, 2) }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-slate-500">Método</p>
                    <p class="font-semibold">{{ $pago->metodo }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Estado</p>
                    <p class="font-semibold capitalize">{{ $pago->estado_pago }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 text-sm font-semibold pt-2">
                <a href="{{ route('pagos.edit', $pago) }}"
                   class="rounded-lg bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">Editar</a>
                <form action="{{ route('pagos.destroy', $pago) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar este pago?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-lg bg-rose-500 px-4 py-2 text-white hover:bg-rose-600">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
