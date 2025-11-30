<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Directorio</p>
                <h1 class="text-2xl font-bold">Grupos</h1>
            </div>
            <a href="{{ route('grupos.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                Nuevo grupo
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
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($grupos as $grupo)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-900">#{{ $grupo->id }}</td>
                            <td class="px-4 py-3">{{ $grupo->nombre }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                                    <a href="{{ route('grupos.show', $grupo) }}"
                                       class="rounded-full bg-slate-900 px-3 py-1 text-white hover:bg-slate-800">Ver</a>
                                    <a href="{{ route('grupos.edit', $grupo) }}"
                                       class="rounded-full bg-slate-100 px-3 py-1 text-slate-800 ring-1 ring-slate-200 hover:bg-slate-200">Editar</a>
                                    <form action="{{ route('grupos.destroy', $grupo) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar este grupo?')" class="inline">
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
                            <td colspan="3" class="px-4 py-6 text-center text-slate-500">No hay grupos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $grupos->links() }}
        </div>
    </div>
</body>
</html>
