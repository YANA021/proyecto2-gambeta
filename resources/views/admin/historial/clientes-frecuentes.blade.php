<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Frecuentes - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-4xl px-6 py-10">
        <header class="mb-6">
            <p class="text-xs uppercase tracking-wide text-slate-500">Ranking</p>
            <h1 class="text-2xl font-bold">🏆 Clientes Más Frecuentes</h1>
            <p class="text-slate-600">TOP 10 clientes por cantidad de reservas</p>
        </header>

        <div class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">#</th>
                        <th class="px-6 py-3 font-semibold">Cliente</th>
                        <th class="px-6 py-3 font-semibold">Teléfono</th>
                        <th class="px-6 py-3 font-semibold">Total Reservas</th>
                        <th class="px-6 py-3 font-semibold">Total Gastado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($clientes as $index => $cliente)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-3">
                                @if($index === 0)
                                    <span class="text-2xl">🥇</span>
                                @elseif($index === 1)
                                    <span class="text-2xl">🥈</span>
                                @elseif($index === 2)
                                    <span class="text-2xl">🥉</span>
                                @else
                                    <span class="font-semibold text-slate-400">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 font-semibold">{{ $cliente->nombre }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $cliente->telefono }}</td>
                            <td class="px-6 py-3">
                                <span class="rounded-full bg-indigo-100 px-3 py-1 text-sm font-bold text-indigo-700">
                                    {{ $cliente->total_reservas }}
                                </span>
                            </td>
                            <td class="px-6 py-3 font-bold text-emerald-600">${{ number_format($cliente->total_gastado, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
