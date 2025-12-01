<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Reserva - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Gestión</p>
                <h1 class="text-2xl font-bold">Nueva Reserva</h1>
            </div>
            <a href="{{ route('reservas.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <!-- Pasamos los parámetros de la URL al componente si existen -->
        <livewire:crear-reserva 
            :cancha_id="request('cancha_id')" 
            :fecha="request('fecha')" 
            :hora="request('hora')" 
        />
    </div>

    @livewireScripts
</body>
</html>
