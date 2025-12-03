<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Gestión</p>
                <h1 class="text-2xl font-bold">Reservas</h1>
            </div>
            <a href="{{ route('reservas.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                Nueva reserva
            </a>
        </header>
        
        <!-- Filtros -->
        <div class="mb-6 rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
            <form action="{{ route('reservas.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="mb-1 block text-xs font-bold uppercase text-slate-500">Fecha</label>
                    <input type="date" name="fecha" value="{{ request('fecha') }}" 
                           class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                </div>
                
                <div class="flex-1 min-w-[200px]">
                    <label class="mb-1 block text-xs font-bold uppercase text-slate-500">Cancha</label>
                    <select name="cancha_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        <option value="">Todas las canchas</option>
                        @foreach($canchas as $id => $nombre)
                            <option value="{{ $id }}" @selected(request('cancha_id') == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label class="mb-1 block text-xs font-bold uppercase text-slate-500">Estado</label>
                    <select name="estado_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        <option value="">Todos los estados</option>
                        @foreach($estados as $id => $nombre)
                            <option value="{{ $id }}" @selected(request('estado_id') == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Filtrar
                    </button>
                    @if(request()->anyFilled(['fecha', 'cancha_id', 'estado_id']))
                        <a href="{{ route('reservas.index') }}" class="ml-2 text-sm text-slate-500 hover:text-slate-700">Limpiar</a>
                    @endif
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-slate-100 bg-white">
            <table class="min-w-full divide-y divide-slate-100 text-sm">
                <thead class="bg-slate-50 text-left font-semibold text-slate-600">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Cancha</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Hora</th>
                        <th class="px-4 py-3">Duración</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Precio</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($reservas as $reserva)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-900">#{{ $reserva->id }}</td>
                            <td class="px-4 py-3">{{ $reserva->cancha->nombre ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $reserva->cliente->nombre ?? '—' }}</td>
                            <td class="px-4 py-3">{{ optional($reserva->fecha)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ $reserva->hora_inicio }}</td>
                            <td class="px-4 py-3">{{ $reserva->duracion_horas }} h</td>
                            <td class="px-4 py-3">{{ $reserva->estado->nombre ?? '—' }}</td>
                            <td class="px-4 py-3">${{ number_format($reserva->precio_total, 2) }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                                    <a href="{{ route('reservas.show', $reserva) }}"
                                       class="rounded-full bg-slate-900 px-3 py-1 text-white hover:bg-slate-800">Ver</a>
                                    <a href="{{ route('reservas.edit', $reserva) }}"
                                       class="rounded-full bg-slate-100 px-3 py-1 text-slate-800 ring-1 ring-slate-200 hover:bg-slate-200">Editar</a>
                                    @if(auth()->user()->hasRole('administrador'))
                                        <form action="{{ route('reservas.destroy', $reserva) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar esta reserva?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-full bg-rose-500 px-3 py-1 text-white hover:bg-rose-600">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-6 text-center text-slate-500">No hay reservas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $reservas->links() }}
        </div>
    </div>
</body>
</html>
