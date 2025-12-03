<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pago - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-2xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Finanzas</p>
                <h1 class="text-2xl font-bold">Registrar Pago</h1>
            </div>
            <a href="{{ route('pagos.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
            <form action="{{ route('pagos.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Reserva</label>
                    <select name="reserva_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        <option value="">Seleccione una reserva...</option>
                        @foreach($reservas as $id => $label)
                            <option value="{{ $id }}">Reserva #{{ $id }}</option>
                        @endforeach
                    </select>
                    @error('reserva_id') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Cliente</label>
                    <p class="text-xs text-slate-500">Se asigna automáticamente al cliente de la reserva seleccionada.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Monto</label>
                        <input type="number" step="0.01" name="monto" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        @error('monto') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Fecha</label>
                        <input type="date" name="fecha_pago" value="{{ date('Y-m-d') }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        @error('fecha_pago') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Método</label>
                        <select name="metodo" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                        @error('metodo') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Estado</label>
                        <p class="text-xs text-slate-500">Se calculará automáticamente según el monto pagado.</p>
                    </div>
                </div>

                <button type="submit" class="mt-4 w-full rounded-lg bg-slate-900 py-2.5 font-bold text-white hover:bg-slate-800">
                    Registrar Pago
                </button>
            </form>
        </div>
    </div>
</body>
</html>
