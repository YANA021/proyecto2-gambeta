<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobantes - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Gestión</p>
                <h1 class="text-2xl font-bold">Comprobantes</h1>
            </div>
            <a href="{{ route('comprobantes.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800">
                Nuevo comprobante
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
                        <th class="px-4 py-3">Pago</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">URL</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($comprobantes as $comprobante)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-900">#{{ $comprobante->id }}</td>
                            <td class="px-4 py-3">#{{ $comprobante->pago_id }}</td>
                            <td class="px-4 py-3">{{ $comprobante->pago->cliente->nombre ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ $comprobante->url_comprobante }}" target="_blank" class="text-slate-700 underline hover:text-slate-900">
                                    Ver comprobante
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                                    <a href="{{ route('comprobantes.show', $comprobante) }}"
                                       class="rounded-full bg-slate-900 px-3 py-1 text-white hover:bg-slate-800">Ver</a>
                                    <a href="{{ route('comprobantes.edit', $comprobante) }}"
                                       class="rounded-full bg-slate-100 px-3 py-1 text-slate-800 ring-1 ring-slate-200 hover:bg-slate-200">Editar</a>
                                    <form action="{{ route('comprobantes.destroy', $comprobante) }}" method="POST"
                                          onsubmit="return confirm('¿Eliminar este comprobante?')" class="inline">
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
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">No hay comprobantes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $comprobantes->links() }}
        </div>
    </div>
</body>
</html>
