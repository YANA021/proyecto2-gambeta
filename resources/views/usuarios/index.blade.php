<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-text-secondary">panel</p>
                <h1 class="text-3xl font-bold text-text-primary">Usuarios</h1>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-border px-4 py-2 text-sm font-semibold text-text-primary hover:bg-bg-secondary transition-colors">
                ← Volver al dashboard
            </a>
        </div>

        @if ($message = session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded">
                {{ $message }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-2xl border border-border bg-bg-surface shadow">
            <table class="w-full text-left text-sm">
                <thead class="bg-bg-secondary/60 text-text-secondary uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Nombre de usuario</th>
                        <th class="px-6 py-3 font-semibold">Rol</th>
                        <th class="px-6 py-3 font-semibold">Creado</th>
                        <th class="px-6 py-3 font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($usuarios as $usuario)
                        <tr class="bg-white hover:bg-bg-secondary/40 transition-colors">
                            <td class="px-6 py-4 font-semibold text-text-primary">{{ $usuario->nombre_usuario }}</td>
                            <td class="px-6 py-4 text-text-secondary capitalize">{{ $usuario->rol->nombre ?? ucfirst(\App\Models\Roles::DEFAULT_ROLE) }}</td>
                            <td class="px-6 py-4 text-text-secondary">{{ $usuario->created_at?->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('usuarios.edit', $usuario) }}" class="rounded-md border border-brand-primary/40 px-3 py-1 text-xs font-semibold text-brand-primary hover:bg-brand-primary hover:text-white">Editar</a>
                                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="inline-flex" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-600 hover:bg-red-100">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-text-secondary">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $usuarios->links() }}
        </div>
    </div>
</body>
</html>
