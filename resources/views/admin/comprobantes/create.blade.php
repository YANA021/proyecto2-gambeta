<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Comprobante - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-3xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Crear</p>
                <h1 class="text-2xl font-bold">Nuevo comprobante</h1>
            </div>
            <a href="{{ route('comprobantes.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
            <form action="{{ route('comprobantes.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-slate-700">Pago</label>
                    <select name="pago_id" required
                            class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        <option value="">Seleccione...</option>
                        @foreach($pagos as $pago)
                            <option value="{{ $pago->id }}" @selected(old('pago_id') == $pago->id)">
                                #{{ $pago->id }} - {{ $pago->cliente->nombre ?? 'Sin cliente' }}
                            </option>
                        @endforeach
                    </select>
                    @error('pago_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">URL del comprobante</label>
                    <input type="url" name="url_comprobante" value="{{ old('url_comprobante') }}" required
                           class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none"
                           placeholder="https://ejemplo.com/archivo.pdf">
                    @error('url_comprobante') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex w-full justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Guardar comprobante
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
