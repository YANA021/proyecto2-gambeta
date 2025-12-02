<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloqueos - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Gestión</p>
                <h1 class="text-2xl font-bold">Bloqueos de Horarios</h1>
            </div>
            <a href="{{ route('bloqueos.create') }}" class="rounded-lg bg-rose-500 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-600">
                🚫 Crear Bloqueo
            </a>
        </header>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-emerald-100 p-4 text-emerald-700">{{ session('success') }}</div>
        @endif

        <div class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Cancha</th>
                        <th class="px-6 py-3 font-semibold">Fecha</th>
                        <th class="px-6 py-3 font-semibold">Horario</th>
                        <th class="px-6 py-3 font-semibold">Motivo</th>
                        <th class="px-6 py-3 font-semibold">Creado por</th>
                        <th class="px-6 py-3 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bloqueos as $bloqueo)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-3 font-semibold">{{ $bloqueo->cancha->nombre }}</td>
                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($bloqueo->fecha)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $bloqueo->hora_inicio }} - {{ $bloqueo->hora_fin }}</td>
                            <td class="px-6 py-3">
                                <span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-700">
                                    {{ $bloqueo->motivo }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-slate-500">{{ $bloqueo->creador->nombre_usuario ?? 'N/D' }}</td>
                            <td class="px-6 py-3">
                                <form action="{{ route('bloqueos.destroy', $bloqueo) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Eliminar este bloqueo?')" class="rounded bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-200">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">No hay bloqueos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $bloqueos->links() }}
        </div>
    </div>
</body>
</html>
