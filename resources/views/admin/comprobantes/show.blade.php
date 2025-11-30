<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante #{{ $comprobante->id }} - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-4xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between gap-3">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Detalle</p>
                <h1 class="text-2xl font-bold">Comprobante #{{ $comprobante->id }}</h1>
            </div>
            <a href="{{ route('comprobantes.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm space-y-4">
            <div>
                <p class="text-sm text-slate-500">Pago</p>
                <p class="text-lg font-semibold text-slate-900">#{{ $comprobante->pago_id }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-500">Cliente</p>
                <p class="font-semibold">{{ $comprobante->pago->cliente->nombre ?? 'Sin cliente' }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-500">URL del comprobante</p>
                <a href="{{ $comprobante->url_comprobante }}" target="_blank"
                   class="font-semibold text-slate-800 underline hover:text-slate-900">
                    Ver comprobante
                </a>
            </div>

            <div class="flex flex-wrap gap-3 text-sm font-semibold pt-2">
                <a href="{{ route('comprobantes.edit', $comprobante) }}"
                   class="rounded-lg bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">Editar</a>
                <form action="{{ route('comprobantes.destroy', $comprobante) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar este comprobante?')">
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
