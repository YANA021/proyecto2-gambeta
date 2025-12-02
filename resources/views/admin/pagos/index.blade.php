<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Finanzas</p>
                <h1 class="text-2xl font-bold">Pagos Registrados</h1>
            </div>
            <a href="{{ route('pagos.create') }}" class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">
                + Registrar Pago
            </a>
        </header>

        <div class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">ID</th>
                        <th class="px-6 py-3 font-semibold">Cliente</th>
                        <th class="px-6 py-3 font-semibold">Reserva</th>
                        <th class="px-6 py-3 font-semibold">Monto</th>
                        <th class="px-6 py-3 font-semibold">Método</th>
                        <th class="px-6 py-3 font-semibold">Fecha</th>
                        <th class="px-6 py-3 font-semibold">Estado</th>
                        <th class="px-6 py-3 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pagos as $pago)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-3 font-mono text-xs text-slate-500">#{{ $pago->id }}</td>
                            <td class="px-6 py-3 font-semibold">{{ $pago->cliente->nombre ?? 'N/D' }}</td>
                            <td class="px-6 py-3 text-slate-500">
                                @if($pago->reserva)
                                    <a href="{{ route('reservas.show', $pago->reserva) }}" class="hover:underline">
                                        Reserva #{{ $pago->reserva->id }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-3 font-bold text-slate-700">${{ number_format($pago->monto, 2) }}</td>
                            <td class="px-6 py-3">{{ ucfirst($pago->metodo) }}</td>
                            <td class="px-6 py-3 text-slate-500">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">
                                <span class="rounded-full px-2 py-1 text-xs font-semibold
                                    {{ $pago->estado_pago === 'completado' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($pago->estado_pago) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('comprobantes.show', $pago->id) }}" target="_blank" 
                                       class="rounded bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-600 hover:bg-slate-200">
                                        📄 PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-slate-500">
                                No hay pagos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $pagos->links() }}
        </div>
    </div>
</body>
</html>
