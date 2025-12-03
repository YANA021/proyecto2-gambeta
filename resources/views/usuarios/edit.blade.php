<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen bg-bg-primary py-12 px-4">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-text-secondary">usuarios</p>
                    <h1 class="text-3xl font-bold text-text-primary">Editar usuario</h1>
                </div>
                <a href="{{ route('usuarios.index') }}" class="rounded-lg border border-border px-4 py-2 text-sm font-semibold text-text-primary hover:bg-bg-secondary transition-colors">
                    ← Volver al listado
                </a>
            </div>

            <div class="rounded-2xl border border-border bg-white p-8 shadow-lg">
                <h2 class="text-xl font-bold text-text-primary mb-6">Información del usuario</h2>

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="nombre_usuario" class="mb-2 block text-sm font-semibold text-text-primary uppercase tracking-wide">Nombre de usuario</label>
                    <input
                        type="text"
                        id="nombre_usuario"
                        name="nombre_usuario"
                        value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}"
                        class="w-full rounded-lg border border-border bg-bg-secondary/40 px-4 py-3 text-text-primary focus:border-brand-primary focus:outline-none focus:ring-1 focus:ring-brand-primary @error('nombre_usuario') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                        required
                    >
                    @error('nombre_usuario')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contrasena" class="mb-2 block text-sm font-semibold text-text-primary uppercase tracking-wide">Contraseña</label>
                    <input
                        type="password"
                        id="contrasena"
                        name="contrasena"
                        class="w-full rounded-lg border border-border bg-bg-secondary/40 px-4 py-3 text-text-primary focus:border-brand-primary focus:outline-none focus:ring-1 focus:ring-brand-primary @error('contrasena') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                        placeholder="Dejar en blanco para mantener la actual"
                    >
                    @error('contrasena')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rol_id" class="mb-2 block text-sm font-semibold text-text-primary uppercase tracking-wide">Rol</label>
                    <select
                        id="rol_id"
                        name="rol_id"
                        class="w-full rounded-lg border border-border bg-bg-secondary/40 px-4 py-3 text-text-primary focus:border-brand-primary focus:outline-none focus:ring-1 focus:ring-brand-primary @error('rol_id') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                    >
                        <option value="">Asignar automáticamente ({{ \App\Models\Roles::DEFAULT_ROLE }})</option>
                        @foreach($roles as $id => $nombre)
                            <option value="{{ $id }}" @selected(old('rol_id', $usuario->rol_id) == $id)>
                                {{ ucfirst($nombre) }}
                            </option>
                        @endforeach
                    </select>
                    @error('rol_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex flex-col gap-3 md:flex-row">
                    <button type="submit" class="flex-1 rounded-lg bg-brand-primary px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-brand-hover focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2">
                        Actualizar usuario
                    </button>
                    <a href="{{ route('usuarios.index') }}" class="flex-1 rounded-lg border border-border px-5 py-3 text-center text-sm font-semibold text-text-primary hover:bg-bg-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>
