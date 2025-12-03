<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pago - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-3xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Editar</p>
                <h1 class="text-2xl font-bold">Pago #{{ $pago->id }}</h1>
            </div>
            <a href="{{ route('pagos.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
            <form action="{{ route('pagos.update', $pago) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-semibold text-slate-700">Reserva</label>
                    <select name="reserva_id" required
                            class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        <option value="">Seleccione...</option>
                        @foreach($reservas as $id)
                            <option value="{{ $id }}" @selected(old('reserva_id', $pago->reserva_id) == $id)>#{{ $id }}</option>
                        @endforeach
                    </select>
                    @error('reserva_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Cliente</label>
                    <p class="text-xs text-slate-500">Se asigna automáticamente al cliente de la reserva seleccionada.</p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Fecha de pago</label>
                        <input type="datetime-local" name="fecha_pago" value="{{ old('fecha_pago', optional($pago->fecha_pago)->format('Y-m-d\TH:i')) }}" required
                               class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        @error('fecha_pago') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Monto</label>
                        <input type="number" step="0.01" min="0" name="monto" value="{{ old('monto', $pago->monto) }}" required
                               class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        @error('monto') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Método</label>
                        <input type="text" name="metodo" value="{{ old('metodo', $pago->metodo) }}" required
                               class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none"
                               placeholder="Ej. efectivo, tarjeta, transferencia">
                        @error('metodo') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Estado</label>
                        <p class="text-xs text-slate-500">Se calculará automáticamente según el monto pagado.</p>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex w-full justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Actualizar pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
