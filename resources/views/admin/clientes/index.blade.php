<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between gap-4 flex-wrap">
            <div class="space-y-1">
                <p class="text-xs uppercase tracking-wide text-slate-500">Directorio</p>
                <h1 class="text-2xl font-bold">Clientes</h1>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-primary hover:text-brand-hover">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver al dashboard
                </a>
            </div>
            <a href="{{ route('clientes.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                Nuevo cliente
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
                        <th class="px-4 py-3">Teléfono</th>
                        <th class="px-4 py-3">Grupo</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($clientes as $cliente)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-900">#{{ $cliente->id }}</td>
                            <td class="px-4 py-3">{{ $cliente->nombre }}</td>
                            <td class="px-4 py-3">{{ $cliente->telefono }}</td>
                            <td class="px-4 py-3">{{ $cliente->grupo->nombre ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                                    <a href="{{ route('clientes.show', $cliente) }}"
                                       class="rounded-full bg-slate-900 px-3 py-1 text-white hover:bg-slate-800">Ver</a>
                                    <a href="{{ route('clientes.edit', $cliente) }}"
                                       class="rounded-full bg-slate-100 px-3 py-1 text-slate-800 ring-1 ring-slate-200 hover:bg-slate-200">Editar</a>
                                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar este cliente?')" class="inline">
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
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">No hay clientes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $clientes->links() }}
        </div>
    </div>
</body>
</html>
