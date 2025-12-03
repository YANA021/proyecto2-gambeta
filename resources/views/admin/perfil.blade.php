<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-text-secondary">mi cuenta</p>
                <h2 class="font-semibold text-xl text-text-primary leading-tight">
                    Perfil
                </h2>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-primary hover:text-brand-hover">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-bg-surface rounded-2xl shadow border border-border p-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-brand-primary to-brand-accent flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($usuario->nombre_usuario ?? 'u', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm text-text-secondary">Usuario</p>
                        <h3 class="text-xl font-bold text-text-primary">{{ $usuario->nombre_usuario }}</h3>
                        <p class="text-sm text-brand-primary font-semibold">{{ $usuario->rol->nombre ?? '—' }}</p>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="rounded-xl border border-border bg-bg-secondary/50 p-4">
                        <p class="text-xs uppercase tracking-wide text-text-secondary mb-1">ID</p>
                        <p class="text-lg font-semibold text-text-primary">#{{ $usuario->id }}</p>
                    </div>
                    <div class="rounded-xl border border-border bg-bg-secondary/50 p-4">
                        <p class="text-xs uppercase tracking-wide text-text-secondary mb-1">Rol</p>
                        <p class="text-lg font-semibold text-text-primary">{{ ucfirst($usuario->rol->nombre ?? '—') }}</p>
                    </div>
                    <div class="rounded-xl border border-border bg-bg-secondary/50 p-4">
                        <p class="text-xs uppercase tracking-wide text-text-secondary mb-1">Creado</p>
                        <p class="text-lg font-semibold text-text-primary">{{ optional($usuario->created_at)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-bg-surface rounded-2xl shadow border border-border p-6">
                    <h4 class="text-lg font-bold text-text-primary mb-4">Actualizar usuario</h4>
                    <form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="rol_id" value="{{ $usuario->rol_id }}">
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Nombre de usuario</label>
                            <input type="text" name="nombre_usuario" value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Rol</label>
                            <input type="text" value="{{ ucfirst($usuario->rol->nombre ?? '—') }}" disabled class="w-full rounded-lg border border-border px-3 py-2 text-sm bg-bg-secondary/60">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2 rounded-lg bg-brand-primary text-white font-semibold hover:bg-brand-hover">Guardar</button>
                        </div>
                    </form>
                </div>

                <div class="bg-bg-surface rounded-2xl shadow border border-border p-6">
                    <h4 class="text-lg font-bold text-text-primary mb-4">Cambiar contraseña</h4>
                    <form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="rol_id" value="{{ $usuario->rol_id }}">
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Nueva contraseña</label>
                            <input type="password" name="contrasena" class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Confirmar contraseña</label>
                            <input type="password" name="contrasena_confirmation" class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2 rounded-lg bg-slate-900 text-white font-semibold hover:bg-slate-800">Actualizar contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
