<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial {{ $cancha->nombre }} - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-6">
            <p class="text-xs uppercase tracking-wide text-slate-500">Historial</p>
            <h1 class="text-2xl font-bold">{{ $cancha->nombre }}</h1>
            <p class="text-slate-600">Todas las reservas de esta cancha</p>
        </header>

        <div class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Fecha</th>
                        <th class="px-6 py-3 font-semibold">Hora</th>
                        <th class="px-6 py-3 font-semibold">Cliente</th>
                        <th class="px-6 py-3 font-semibold">Duración</th>
                        <th class="px-6 py-3 font-semibold">Estado</th>
                        <th class="px-6 py-3 font-semibold">Precio</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($reservas as $reserva)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-3 font-semibold">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3">{{ $reserva->hora_inicio }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $reserva->cliente->nombre }}</td>
                            <td class="px-6 py-3">{{ $reserva->duracion_horas }}h</td>
                            <td class="px-6 py-3">
                                <span class="rounded-full px-2 py-1 text-xs font-semibold 
                                    {{ $reserva->estado->nombre === 'Confirmada' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $reserva->estado->nombre }}
                                </span>
                            </td>
                            <td class="px-6 py-3 font-bold text-slate-700">${{ number_format($reserva->precio_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $reservas->links() }}
        </div>
    </div>
</body>
</html>
