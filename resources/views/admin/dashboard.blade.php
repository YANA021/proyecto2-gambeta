<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-primary leading-tight">
            {{ __('panel de administración') }}
        </h2>
    </x-slot>

    @php
        $isAdmin = strtolower(auth()->user()->rol->nombre ?? '') === 'administrador';
    @endphp

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800 shadow">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- hero section -->
            <div class="bg-gradient-to-br from-bg-surface via-bg-surface to-brand-primary/5 rounded-2xl shadow-lg p-6 md:p-8 relative overflow-hidden border border-border">
                <!-- efectos decorativos de fondo -->
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-64 h-64 bg-brand-accent opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-48 h-48 bg-brand-primary opacity-5 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-brand-primary/20 bg-brand-primary/10 text-sm text-brand-primary mb-3 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-brand-primary animate-pulse"></span>
                            panel activo
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-text-primary mb-2 tracking-tight">gambeta operations</h1>
                        <p class="text-text-secondary text-sm md:text-base">gestiona canchas, clientes y cobros desde una sola vista</p>
                    </div>
                    
                    <!-- botones de acción rápida -->
                    <div class="flex flex-wrap gap-2 w-full md:w-auto">
                        <button type="button" onclick="window.Livewire?.dispatch('openModalCancha')" class="flex-1 md:flex-none px-4 py-2.5 rounded-lg border border-border text-text-primary hover:bg-bg-secondary hover:border-brand-primary/50 transition-all duration-200 flex items-center justify-center gap-2 group">
                            <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-sm font-medium">nueva cancha</span>
                        </button>
                        <button type="button" onclick="window.Livewire?.dispatch('openModalCliente')" class="flex-1 md:flex-none px-4 py-2.5 rounded-lg border border-border text-text-primary hover:bg-bg-secondary hover:border-brand-primary/50 transition-all duration-200 flex items-center justify-center gap-2 group">
                            <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <span class="text-sm font-medium">nuevo cliente</span>
                        </button>
                        <button type="button" onclick="window.Livewire?.dispatch('openModalReserva')" class="flex-1 md:flex-none px-4 py-2.5 rounded-lg bg-brand-primary text-white hover:bg-brand-hover transition-all duration-200 flex items-center justify-center gap-2 font-semibold shadow-lg shadow-brand-primary/20 hover:shadow-xl hover:shadow-brand-primary/40 group">
                            <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-sm">crear reserva</span>
                        </button>
                    </div>
                </div>

                <!-- tarjetas de estadísticas -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mt-6 relative z-10">
                    <!-- canchas activas -->
                    <div class="bg-bg-secondary/80 backdrop-blur-sm rounded-xl p-4 border border-border hover:border-brand-primary/50 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 group cursor-pointer">
                        <div class="flex justify-between items-start mb-3">
                            <span class="text-text-secondary text-xs md:text-sm font-medium">canchas activas</span>
                            <div class="w-8 h-8 rounded-lg bg-brand-primary/10 flex items-center justify-center group-hover:bg-brand-primary/20 transition-colors">
                                <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-text-primary">{{ $stats['canchas'] ?? 0 }}</h3>
                    </div>

                    <!-- clientes -->
                    <div class="bg-bg-secondary/80 backdrop-blur-sm rounded-xl p-4 border border-border hover:border-brand-primary/50 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 group cursor-pointer">
                        <div class="flex justify-between items-start mb-3">
                            <span class="text-text-secondary text-xs md:text-sm font-medium">clientes</span>
                            <div class="w-8 h-8 rounded-lg bg-brand-primary/10 flex items-center justify-center group-hover:bg-brand-primary/20 transition-colors">
                                <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-text-primary">{{ $stats['clientes'] ?? 0 }}</h3>
                    </div>

                    <!-- reservas -->
                    <div class="bg-bg-secondary/80 backdrop-blur-sm rounded-xl p-4 border border-border hover:border-brand-primary/50 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 group cursor-pointer">
                        <div class="flex justify-between items-start mb-3">
                            <span class="text-text-secondary text-xs md:text-sm font-medium">reservas</span>
                            <div class="w-8 h-8 rounded-lg bg-brand-primary/10 flex items-center justify-center group-hover:bg-brand-primary/20 transition-colors">
                                <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-text-primary">{{ $stats['reservas'] ?? 0 }}</h3>
                    </div>

                    <!-- pagos -->
                    <div class="bg-bg-secondary/80 backdrop-blur-sm rounded-xl p-4 border border-border hover:border-brand-primary/50 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 group cursor-pointer">
                        <div class="flex justify-between items-start mb-3">
                            <span class="text-text-secondary text-xs md:text-sm font-medium">pagos</span>
                            <div class="w-8 h-8 rounded-lg bg-brand-primary/10 flex items-center justify-center group-hover:bg-brand-primary/20 transition-colors">
                                <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-text-primary">{{ $stats['pagos'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- columna principal -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- últimas reservas -->
                    <div class="bg-bg-surface rounded-xl shadow-md p-6 border border-border hover:shadow-lg transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <p class="text-xs uppercase tracking-wider text-text-secondary mb-1 font-semibold">reservas</p>
                                <h5 class="text-lg font-bold text-text-primary">últimas reservas creadas</h5>
                            </div>
                            <a href="{{ route('reservas.index') }}" class="text-sm text-brand-primary hover:text-brand-hover font-medium flex items-center gap-1 group">
                                ver todas
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        
                        <!-- tabla desktop / tarjetas mobile -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-text-secondary border-b border-border">
                                        <th class="pb-3 font-semibold text-xs uppercase tracking-wider">#</th>
                                        <th class="pb-3 font-semibold text-xs uppercase tracking-wider">cancha</th>
                                        <th class="pb-3 font-semibold text-xs uppercase tracking-wider">cliente</th>
                                        <th class="pb-3 font-semibold text-xs uppercase tracking-wider">fecha</th>
                                        <th class="pb-3 font-semibold text-xs uppercase tracking-wider">estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @forelse($recentReservas as $reserva)
                                        <tr class="text-text-primary hover:bg-bg-secondary/50 transition-colors">
                                            <td class="py-3 font-medium">#{{ $reserva->id }}</td>
                                            <td class="py-3">{{ $reserva->cancha->nombre ?? 'n/d' }}</td>
                                            <td class="py-3">{{ $reserva->cliente->nombre ?? 'n/d' }}</td>
                                            <td class="py-3 text-sm">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }} {{ $reserva->hora_inicio }}</td>
                                            <td class="py-3">
                                                <span class="px-2 py-1 rounded-md text-xs font-semibold
                                                    {{ ($reserva->estado->nombre ?? '') === 'cancelada' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                                                       (($reserva->estado->nombre ?? '') === 'pendiente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                                       'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200') }}">
                                                    {{ $reserva->estado->nombre ?? 'pendiente' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-text-secondary">sin reservas todavía</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- vista mobile (tarjetas) -->
                        <div class="md:hidden space-y-3">
                            @forelse($recentReservas as $reserva)
                                <div class="bg-bg-secondary/50 rounded-lg p-4 border border-border">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-semibold text-text-primary">#{{ $reserva->id }}</span>
                                        <span class="px-2 py-0.5 rounded-md text-xs font-semibold
                                            {{ ($reserva->estado->nombre ?? '') === 'cancelada' ? 'bg-red-100 text-red-800' : 
                                               (($reserva->estado->nombre ?? '') === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-green-100 text-green-800') }}">
                                            {{ $reserva->estado->nombre ?? 'pendiente' }}
                                        </span>
                                    </div>
                                    <div class="text-sm space-y-1">
                                        <p class="text-text-primary"><span class="text-text-secondary">cancha:</span> {{ $reserva->cancha->nombre ?? 'n/d' }}</p>
                                        <p class="text-text-primary"><span class="text-text-secondary">cliente:</span> {{ $reserva->cliente->nombre ?? 'n/d' }}</p>
                                        <p class="text-text-secondary text-xs">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }} {{ $reserva->hora_inicio }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-text-secondary py-8">sin reservas todavía</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- pagos recientes -->
                    <div class="bg-bg-surface rounded-xl shadow-md p-6 border border-border hover:shadow-lg transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <p class="text-xs uppercase tracking-wider text-text-secondary mb-1 font-semibold">pagos</p>
                                <h5 class="text-lg font-bold text-text-primary">pagos recientes</h5>
                            </div>
                            <a href="{{ route('pagos.index') }}" class="text-sm text-brand-primary hover:text-brand-hover font-medium flex items-center gap-1 group">
                                ver pagos
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recentPagos as $pago)
                                <div class="flex justify-between items-center p-3 rounded-lg hover:bg-bg-secondary/50 transition-all duration-200 border border-transparent hover:border-border group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-brand-primary/10 flex items-center justify-center border border-brand-primary/20 group-hover:bg-brand-primary/20 transition-colors">
                                            <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-text-primary text-sm">{{ $pago->cliente->nombre ?? 'cliente' }}</div>
                                            <div class="text-xs text-text-secondary">{{ $pago->metodo ?? 'método no especificado' }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-text-primary">${{ number_format($pago->monto ?? 0, 2) }}</div>
                                        <span class="text-xs px-2 py-0.5 rounded-md font-medium
                                            {{ ($pago->estado_pago ?? '') === 'fallido' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $pago->estado_pago ?? 'pendiente' }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-text-secondary py-8">sin pagos registrados</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- barra lateral -->
                <div class="space-y-6">
                    <!-- perfil -->
                    <div class="bg-bg-surface rounded-xl shadow-md p-6 border border-border">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-brand-primary to-brand-accent flex items-center justify-center text-xl font-bold text-white shadow-lg ring-2 ring-white dark:ring-gray-800">
                                {{ strtoupper(substr(auth()->user()->name ?? 'a', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-text-secondary mb-1 font-semibold">mi perfil</p>
                                <h6 class="font-bold text-text-primary">{{ auth()->user()->name ?? 'administrador' }}</h6>
                                <p class="text-xs text-text-secondary truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('clientes.index') }}" class="block w-full text-left px-4 py-2.5 rounded-lg border border-border text-text-primary hover:bg-bg-secondary hover:border-brand-primary/50 transition-all duration-200 flex items-center gap-3 group">
                                <svg class="w-4 h-4 text-text-secondary group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="text-sm">lista de clientes</span>
                            </a>
                            <a href="{{ route('canchas.index') }}" class="block w-full text-left px-4 py-2.5 rounded-lg border border-border text-text-primary hover:bg-bg-secondary hover:border-brand-primary/50 transition-all duration-200 flex items-center gap-3 group">
                                <svg class="w-4 h-4 text-text-secondary group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="text-sm">gestión de canchas</span>
                            </a>
                            <a href="{{ route('grupos.index') }}" class="block w-full text-left px-4 py-2.5 rounded-lg border border-border text-text-primary hover:bg-bg-secondary hover:border-brand-primary/50 transition-all duration-200 flex items-center gap-3 group">
                                <svg class="w-4 h-4 text-text-secondary group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="text-sm">grupos y equipos</span>
                            </a>
                            <a href="{{ route('reservas.calendar') }}" class="block w-full text-left px-4 py-2.5 rounded-lg border border-border text-text-primary hover:bg-bg-secondary hover:border-brand-primary/50 transition-all duration-200 flex items-center gap-3 group">
                                <svg class="w-4 h-4 text-text-secondary group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm">calendario de reservas</span>
                            </a>
                            <a href="{{ route('estados_reserva.index') }}" class="block w-full text-left px-4 py-2.5 rounded-lg border border-border text-text-primary hover:bg-bg-secondary hover:border-brand-primary/50 transition-all duration-200 flex items-center gap-3 group">
                                <svg class="w-4 h-4 text-text-secondary group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                <span class="text-sm">estados de reserva</span>
                            </a>
                        </div>
                    </div>

                    @if($isAdmin)
                        <div class="bg-bg-surface rounded-xl shadow-md p-6 border border-border">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-text-secondary mb-1 font-semibold">usuarios</p>
                                    <h6 class="font-bold text-text-primary">crear usuario rápido</h6>
                                </div>
                                <a href="{{ route('usuarios.index') }}" class="text-xs font-semibold text-brand-primary hover:text-brand-hover">ver todos</a>
                            </div>

                            <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="redirect_to_dashboard" value="1">

                                <div>
                                    <label for="nombre_usuario" class="block text-xs font-semibold uppercase tracking-wide text-text-secondary mb-1">nombre de usuario</label>
                                    <input
                                        type="text"
                                        id="nombre_usuario"
                                        name="nombre_usuario"
                                        value="{{ old('nombre_usuario') }}"
                                        class="w-full rounded-lg border border-border bg-bg-secondary/40 px-3 py-2 text-sm text-text-primary focus:border-brand-primary focus:outline-none focus:ring-1 focus:ring-brand-primary @error('nombre_usuario') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                                        placeholder="ej: admin.gambeta"
                                        required
                                    >
                                    @error('nombre_usuario')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="contrasena" class="block text-xs font-semibold uppercase tracking-wide text-text-secondary mb-1">contraseña</label>
                                    <input
                                        type="password"
                                        id="contrasena"
                                        name="contrasena"
                                        class="w-full rounded-lg border border-border bg-bg-secondary/40 px-3 py-2 text-sm text-text-primary focus:border-brand-primary focus:outline-none focus:ring-1 focus:ring-brand-primary @error('contrasena') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                                        placeholder="mínimo 8 caracteres"
                                        required
                                    >
                                    @error('contrasena')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="rol_id" class="block text-xs font-semibold uppercase tracking-wide text-text-secondary mb-1">rol</label>
                                    <select
                                        id="rol_id"
                                        name="rol_id"
                                        class="w-full rounded-lg border border-border bg-bg-secondary/40 px-3 py-2 text-sm text-text-primary focus:border-brand-primary focus:outline-none focus:ring-1 focus:ring-brand-primary @error('rol_id') border-red-400 focus:border-red-500 focus:ring-red-500 @enderror"
                                        required
                                    >
                                        <option value="" disabled {{ old('rol_id') ? '' : 'selected' }}>selecciona un rol</option>
                                        @foreach(($rolesDisponibles ?? collect()) as $rol)
                                            <option value="{{ $rol->id }}" @selected(old('rol_id') == $rol->id)>{{ ucfirst($rol->nombre) }}</option>
                                        @endforeach
                                    </select>
                                    @error('rol_id')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="w-full rounded-lg bg-brand-primary py-2 text-sm font-semibold text-white transition-all duration-200 hover:bg-brand-hover focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2">
                                    crear usuario
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- tipos de cancha -->
                    <div class="bg-bg-surface rounded-xl shadow-md p-6 border border-border">
                        <div class="flex justify-between items-center mb-4">
                            <h6 class="font-bold text-text-primary">tipos de cancha</h6>
                            <a href="{{ route('tipo_canchas.index') }}" class="text-sm text-brand-primary hover:text-brand-hover font-medium">ver</a>
                        </div>
                        <ul class="space-y-2">
                            @forelse($tipos as $tipo)
                                <li class="flex justify-between items-center p-2.5 rounded-lg hover:bg-bg-secondary/50 transition-all duration-200 group border border-transparent hover:border-border">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-brand-primary/10 flex items-center justify-center group-hover:bg-brand-primary/20 transition-colors">
                                            <svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm text-text-primary font-medium">{{ $tipo->nombre }}</span>
                                    </div>
                                    <span class="px-2 py-1 rounded-md bg-brand-primary/10 text-brand-primary text-xs font-semibold">
                                        {{ $tipo->precio_hora ?? '—' }}
                                    </span>
                                </li>
                            @empty
                                <li class="text-text-secondary text-sm text-center py-4">sin tipos registrados</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nueva Cancha -->
    <livewire:admin-crear-cancha />

    <!-- Modal Nuevo Cliente -->
    <livewire:admin-crear-cliente />

    <livewire:admin-crear-reserva />

</x-app-layout>
