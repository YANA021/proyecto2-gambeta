<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - Gambeta</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-bg-primary text-text-primary min-h-screen flex items-center justify-center p-4">
    <!-- fondo decorativo -->
    <div class="fixed inset-0 overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-brand-accent opacity-10 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-brand-primary opacity-10 blur-3xl"></div>
    </div>

    <div class="w-full max-w-md bg-bg-surface rounded-2xl shadow-xl border border-border p-8 my-8 transform transition-all">
        <div class="text-center mb-8">
            <a href="{{ route('welcome') }}" class="inline-block transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('images/logo_gambeta.png') }}" alt="Gambeta Logo" class="h-24 mx-auto mb-4 object-contain">
            </a>
            <h2 class="text-2xl font-bold text-brand-primary">Crear Cuenta</h2>
            <p class="text-text-secondary mt-2">Únete a Gambeta hoy mismo</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="nombre" class="block text-sm font-medium text-text-primary mb-1">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" 
                    class="w-full px-4 py-2.5 rounded-lg bg-bg-secondary border border-border text-text-primary focus:ring-2 focus:ring-brand-primary focus:border-transparent transition-all outline-none" 
                    placeholder="Su nombre completo" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="telefono" class="block text-sm font-medium text-text-primary mb-1">Teléfono</label>
                <input type="text" id="telefono" name="telefono" 
                    class="w-full px-4 py-2.5 rounded-lg bg-bg-secondary border border-border text-text-primary focus:ring-2 focus:ring-brand-primary focus:border-transparent transition-all outline-none" 
                    placeholder="Su número de teléfono" value="{{ old('telefono') }}" required>
                @error('telefono')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nombre_usuario" class="block text-sm font-medium text-text-primary mb-1">Usuario</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" 
                    class="w-full px-4 py-2.5 rounded-lg bg-bg-secondary border border-border text-text-primary focus:ring-2 focus:ring-brand-primary focus:border-transparent transition-all outline-none" 
                    placeholder="Elija un usuario" value="{{ old('nombre_usuario') }}" required>
                @error('nombre_usuario')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="contrasena" class="block text-sm font-medium text-text-primary mb-1">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" 
                    class="w-full px-4 py-2.5 rounded-lg bg-bg-secondary border border-border text-text-primary focus:ring-2 focus:ring-brand-primary focus:border-transparent transition-all outline-none" 
                    placeholder="Mínimo 8 caracteres" required>
                @error('contrasena')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="contrasena_confirmation" class="block text-sm font-medium text-text-primary mb-1">Confirmar Contraseña</label>
                <input type="password" id="contrasena_confirmation" name="contrasena_confirmation" 
                    class="w-full px-4 py-2.5 rounded-lg bg-bg-secondary border border-border text-text-primary focus:ring-2 focus:ring-brand-primary focus:border-transparent transition-all outline-none" 
                    placeholder="Repita la contraseña" required>
            </div>

            <div>
                <label for="nombre_equipo" class="block text-sm font-medium text-text-primary mb-1">Nombre del Equipo (Opcional)</label>
                <input type="text" id="nombre_equipo" name="nombre_equipo" 
                    class="w-full px-4 py-2.5 rounded-lg bg-bg-secondary border border-border text-text-primary focus:ring-2 focus:ring-brand-primary focus:border-transparent transition-all outline-none" 
                    placeholder="Nombre de su equipo" value="{{ old('nombre_equipo') }}">
                @error('nombre_equipo')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-brand-primary hover:bg-brand-hover text-white font-semibold rounded-lg shadow-md transition-all duration-300 transform hover:-translate-y-0.5 mt-2">
                Registrarse
            </button>
            
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-brand-primary hover:text-brand-hover hover:underline transition-colors">
                    ¿Ya tienes cuenta? Inicia sesión
                </a>
            </div>
        </form>
    </div>
</body>
</html>
