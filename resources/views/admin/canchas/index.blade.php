<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canchas - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Inventario</p>
                <h1 class="text-2xl font-bold">Canchas</h1>
            </div>
            <a href="{{ route('canchas.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                Nueva cancha
            </a>
        </header>

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
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Tipo</th>
                        <th class="px-4 py-3">Precio hora</th>
                        <th class="px-4 py-3">Disponibilidad</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($canchas as $cancha)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-900">#{{ $cancha->id }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($cancha->foto)
                                        <img src="{{ Storage::url($cancha->foto) }}" alt="{{ $cancha->nombre }}" class="h-10 w-10 rounded-lg object-cover">
                                    @else
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-400">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <span>{{ $cancha->nombre }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">{{ $cancha->tipoCancha->nombre ?? '—' }}</td>
                            <td class="px-4 py-3">${{ number_format($cancha->precio_hora, 2) }}</td>
                            <td class="px-4 py-3">
                                @if($cancha->disponible)
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Disponible</span>
                                @else
                                    <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">No disponible</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                                    <a href="{{ route('canchas.show', $cancha) }}"
                                       class="rounded-full bg-slate-900 px-3 py-1 text-white hover:bg-slate-800">Ver</a>
                                    <a href="{{ route('canchas.edit', $cancha) }}"
                                       class="rounded-full bg-slate-100 px-3 py-1 text-slate-800 ring-1 ring-slate-200 hover:bg-slate-200">Editar</a>
                                    <a href="{{ route('historial.porCancha', $cancha->id) }}"
                                       class="rounded-full bg-indigo-100 px-3 py-1 text-indigo-800 ring-1 ring-indigo-200 hover:bg-indigo-200">📋 Historial</a>
                                    <form action="{{ route('canchas.destroy', $cancha) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar esta cancha?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-full bg-rose-500 px-3 py-1 text-white hover:bg-rose-600">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-slate-500">No hay canchas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $canchas->links() }}
        </div>
    </div>
</body>
</html>
