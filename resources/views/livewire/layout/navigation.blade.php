<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="z-50">
    <!-- mobile top bar -->
    <div class="md:hidden fixed w-full bg-bg-surface/95 backdrop-blur-md border-b border-border h-16 flex items-center justify-between px-4 z-50 shadow-sm">
        <!-- logo -->
        <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-2 group">
            <img src="{{ asset('images/logo_gambeta.png') }}" alt="gambeta" class="h-8 w-auto transition-transform duration-300 group-active:scale-95">
            <span class="font-bold text-lg text-text-primary tracking-tight">gambeta</span>
        </a>

        <!-- hamburger button -->
        <button @click="open = !open" class="inline-flex items-center justify-center p-2.5 rounded-lg text-text-secondary hover:text-brand-primary hover:bg-bg-secondary/50 focus:outline-none transition-all duration-200 active:scale-95" aria-label="menú de navegación">
            <svg class="h-6 w-6 transition-all duration-300" :class="{'rotate-90': open}" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- sidebar (desktop y mobile off-canvas) -->
    <div :class="{'translate-x-0': open, '-translate-x-full': !open}" 
         class="fixed inset-y-0 left-0 z-40 w-64 bg-bg-surface border-r border-border transition-transform duration-300 ease-in-out md:translate-x-0 shadow-2xl md:shadow-none flex flex-col">
        
        <!-- sidebar header (logo) -->
        <div class="h-20 flex items-center px-6 border-b border-border/50 bg-gradient-to-br from-bg-surface to-bg-secondary/30">
            <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo_gambeta.png') }}" alt="gambeta" class="h-10 w-auto transition-all duration-300 group-hover:scale-110 group-hover:rotate-3">
                <span class="font-bold text-xl text-text-primary tracking-tight group-hover:text-brand-primary transition-colors duration-300">gambeta</span>
            </a>
        </div>

        <!-- navigation links -->
        <div class="flex-1 overflow-y-auto py-6 px-3 space-y-1 scrollbar-thin">
            <!-- dashboard link -->
            @php
                $dashboardRoute = auth()->user()->rol->nombre === 'Administrador' ? 'admin.dashboard' : 'cliente.dashboard';
                $dashboardUrl = auth()->user()->rol->nombre === 'Administrador' ? url('/admin') : url('/cliente');
                $isDashboardActive = request()->routeIs($dashboardRoute);
            @endphp
            
            <a href="{{ $dashboardUrl }}" wire:navigate class="relative flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ $isDashboardActive ? 'bg-brand-primary/10 text-brand-primary font-semibold' : 'text-text-secondary hover:bg-bg-secondary hover:text-text-primary' }}">
                <!-- indicador de ruta activa -->
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-brand-primary rounded-r-full transition-all duration-200 {{ $isDashboardActive ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }}"></div>
                
                <!-- icono svg dashboard -->
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-medium">dashboard</span>
            </a>

            @if(auth()->user()->rol->nombre === 'Administrador')
                <div class="pt-4 pb-2 px-4 text-xs font-bold text-text-secondary uppercase tracking-wider">gestión</div>
                
                @php $isReservasActive = request()->routeIs('reservas.*'); @endphp
                <a href="{{ route('reservas.index') }}" wire:navigate class="relative flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ $isReservasActive ? 'bg-brand-primary/10 text-brand-primary font-semibold' : 'text-text-secondary hover:bg-bg-secondary hover:text-text-primary' }}">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-brand-primary rounded-r-full transition-all duration-200 {{ $isReservasActive ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }}"></div>
                    
                    <!-- icono svg calendario -->
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">reservas</span>
                </a>
                
                @php $isCanchasActive = request()->routeIs('canchas.*'); @endphp
                <a href="{{ route('canchas.index') }}" wire:navigate class="relative flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ $isCanchasActive ? 'bg-brand-primary/10 text-brand-primary font-semibold' : 'text-text-secondary hover:bg-bg-secondary hover:text-text-primary' }}">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-brand-primary rounded-r-full transition-all duration-200 {{ $isCanchasActive ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }}"></div>
                    
                    <!-- icono svg cancha -->
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="font-medium">canchas</span>
                </a>

                @php $isClientesActive = request()->routeIs('clientes.*'); @endphp
                <a href="{{ route('clientes.index') }}" wire:navigate class="relative flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ $isClientesActive ? 'bg-brand-primary/10 text-brand-primary font-semibold' : 'text-text-secondary hover:bg-bg-secondary hover:text-text-primary' }}">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-brand-primary rounded-r-full transition-all duration-200 {{ $isClientesActive ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }}"></div>
                    
                    <!-- icono svg usuarios -->
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="font-medium">clientes</span>
                </a>

                @php $isPagosActive = request()->routeIs('pagos.*'); @endphp
                <a href="{{ route('pagos.index') }}" wire:navigate class="relative flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ $isPagosActive ? 'bg-brand-primary/10 text-brand-primary font-semibold' : 'text-text-secondary hover:bg-bg-secondary hover:text-text-primary' }}">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-brand-primary rounded-r-full transition-all duration-200 {{ $isPagosActive ? 'opacity-100 scale-100' : 'opacity-0 scale-0' }}"></div>
                    
                    <!-- icono svg pagos -->
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <span class="font-medium">pagos</span>
                </a>
            @else
                <div class="pt-4 pb-2 px-4 text-xs font-bold text-text-secondary uppercase tracking-wider">mi actividad</div>
                
                <a href="#" class="relative flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group text-text-secondary hover:bg-bg-secondary hover:text-text-primary">
                    <!-- icono svg fútbol -->
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">reservar</span>
                </a>
                
                <a href="#" class="relative flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group text-text-secondary hover:bg-bg-secondary hover:text-text-primary">
                    <!-- icono svg lista -->
                    <svg class="w-5 h-5 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="font-medium">mis reservas</span>
                </a>
            @endif
        </div>

        <!-- user profile (bottom) -->
        <div class="p-4 border-t border-border/50 bg-gradient-to-t from-bg-secondary/50 to-transparent">
            <div x-data="{ userMenuOpen: false }" class="relative">
                <button @click="userMenuOpen = !userMenuOpen" class="w-full flex items-center gap-3 p-2 rounded-lg hover:bg-bg-secondary transition-all duration-200 group">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-primary to-brand-accent flex items-center justify-center text-white font-bold shadow-md ring-2 ring-transparent group-hover:ring-brand-primary/30 transition-all">
                        {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->nombre_usuario ?? 'u', 0, 1)) }}
                    </div>
                    <div class="flex-1 text-left overflow-hidden">
                        <p class="text-sm font-bold text-text-primary truncate">{{ auth()->user()->name ?? auth()->user()->nombre_usuario }}</p>
                        <p class="text-xs text-text-secondary truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <svg class="w-5 h-5 text-text-secondary transition-transform duration-200" :class="{'rotate-180': userMenuOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <!-- user dropdown -->
                <div x-show="userMenuOpen" 
                     @click.away="userMenuOpen = false" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     class="absolute bottom-full left-0 w-full mb-2 bg-bg-surface border border-border rounded-xl shadow-xl overflow-hidden z-50">
                    
                    <a href="{{ url('/profile') }}" wire:navigate class="block px-4 py-3 text-sm text-text-primary hover:bg-bg-secondary hover:text-brand-primary transition-colors flex items-center gap-3">
                        <!-- icono svg perfil -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        perfil
                    </a>
                    
                    <button wire:click="logout" class="w-full text-left px-4 py-3 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors flex items-center gap-3 border-t border-border/50">
                        <!-- icono svg logout -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        cerrar sesión
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- overlay para móvil -->
    <div x-show="open" 
         @click="open = false" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 md:hidden">
    </div>
</nav>
