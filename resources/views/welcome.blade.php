<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gambeta | Reserva tu cancha</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-bg-primary text-text-primary min-h-screen flex flex-col">
    <x-splash />

    <div class="relative flex flex-col items-center justify-center min-h-screen selection:bg-brand-primary selection:text-white">
        <!-- fondo decorativo -->
        <div class="absolute inset-0 overflow-hidden -z-10">
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-brand-accent opacity-20 blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-brand-primary opacity-20 blur-3xl"></div>
        </div>

        <div class="w-full max-w-7xl mx-auto p-6 lg:p-8 flex flex-col items-center justify-center">
            <!-- logo -->
            <div class="mb-12 transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('images/logo_gambeta.png') }}" alt="Gambeta Logo" class="h-48 w-auto md:h-64 drop-shadow-xl">
            </div>

            <!-- botones de accion -->
            <div class="flex flex-col sm:flex-row gap-4 w-full max-w-md justify-center items-center">
                @auth
                    @php
                        $isAdmin = auth()->user()->hasRole('Administrador') || strtolower(auth()->user()->rol->nombre) === 'administrador';
                        $dashboardRoute = $isAdmin ? 'admin.dashboard' : 'empleado.dashboard';
                    @endphp
                    
                    <a href="{{ route($dashboardRoute) }}" class="w-full sm:w-auto px-8 py-3 bg-brand-primary hover:bg-brand-hover text-white font-semibold rounded-full shadow-lg transition-all duration-300 transform hover:-translate-y-1 text-center">
                        ir al panel
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full px-8 py-3 bg-transparent border-2 border-brand-primary text-brand-primary hover:bg-brand-primary hover:text-white font-semibold rounded-full transition-all duration-300 text-center">
                            cerrar sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3 bg-brand-primary hover:bg-brand-hover text-white font-semibold rounded-full shadow-lg transition-all duration-300 transform hover:-translate-y-1 text-center">
                        iniciar sesión
                    </a>
                @endauth
            </div>
        </div>

        <!-- footer simple -->
        <div class="absolute bottom-4 text-center text-sm text-text-secondary">
          Todos los derechos reservados {{ date('Y') }}  &copy; Gambeta
        </div>
    </div>
</body>
</html>
