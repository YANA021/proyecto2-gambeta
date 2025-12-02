<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-text-primary leading-tight">
            {{ __('mi panel') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- hero de bienvenida personalizado -->
            <div class="bg-gradient-to-br from-brand-primary via-brand-primary to-brand-hover rounded-2xl shadow-xl p-6 md:p-8 relative overflow-hidden">
                <!-- efectos decorativos de fondo -->
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- avatar del usuario -->
                    <div class="flex-shrink-0">
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-white/20 backdrop-blur-sm border-4 border-white/30 flex items-center justify-center shadow-2xl">
                            <span class="text-3xl md:text-4xl font-bold text-white">
                                {{ strtoupper(substr(auth()->user()->nombre_usuario ?? 'u', 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- mensaje de bienvenida -->
                    <div class="flex-1 text-center md:text-left">
                        @php
                            $hora = now()->format('H');
                            $saludo = $hora < 12 ? 'buenos días' : ($hora < 19 ? 'buenas tardes' : 'buenas noches');
                        @endphp
                        <p class="text-white/80 text-sm mb-1">{{ $saludo }},</p>
                        <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                            {{ auth()->user()->nombre_usuario }}
                        </h1>
                        <p class="text-white/90 text-sm md:text-base">
                            ¿listo para reservar tu próxima cancha?
                        </p>
                    </div>
                    
                    <!-- fecha y hora actual -->
                    <div class="hidden md:block text-right text-white/90">
                        <p class="text-sm font-medium">{{ now()->locale('es')->isoFormat('dddd') }}</p>
                        <p class="text-2xl font-bold">{{ now()->format('d') }}</p>
                        <p class="text-sm">{{ now()->locale('es')->isoFormat('MMMM') }}</p>
                    </div>
                </div>
            </div>

            <!-- acciones rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- reservar cancha -->
                <a href="#" class="group bg-gradient-to-br from-bg-surface to-brand-primary/5 rounded-xl shadow-md hover:shadow-xl p-6 border border-border hover:border-brand-primary/50 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-14 h-14 rounded-xl bg-brand-primary/10 flex items-center justify-center group-hover:bg-brand-primary/20 transition-colors">
                            <svg class="w-7 h-7 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-text-primary group-hover:text-brand-primary transition-colors mb-1">
                                reservar cancha
                            </h3>
                            <p class="text-sm text-text-secondary">
                                encuentra la cancha perfecta para tu partido
                            </p>
                        </div>
                        <svg class="w-6 h-6 text-text-secondary group-hover:text-brand-primary group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <!-- mis reservas -->
                <a href="#" class="group bg-gradient-to-br from-bg-surface to-brand-accent/5 rounded-xl shadow-md hover:shadow-xl p-6 border border-border hover:border-brand-primary/50 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-14 h-14 rounded-xl bg-brand-primary/10 flex items-center justify-center group-hover:bg-brand-primary/20 transition-colors">
                            <svg class="w-7 h-7 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-text-primary group-hover:text-brand-primary transition-colors mb-1">
                                mis reservas
                            </h3>
                            <p class="text-sm text-text-secondary">
                                revisa y gestiona tus reservas activas
                            </p>
                        </div>
                        <svg class="w-6 h-6 text-text-secondary group-hover:text-brand-primary group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- grid de contenido -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- columna principal -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- próximos partidos -->
                    <div class="bg-bg-surface rounded-xl shadow-md p-6 border border-border">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <p class="text-xs uppercase tracking-wider text-text-secondary mb-1 font-semibold">agenda</p>
                                <h3 class="text-lg font-bold text-text-primary">mis próximos partidos</h3>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-brand-primary/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- lista de próximas reservas -->
                        <div class="space-y-3">
                            <!-- ejemplo de reserva (vacío por ahora) -->
                            <div class="bg-bg-secondary/30 rounded-xl p-4 border-2 border-dashed border-border text-center">
                                <svg class="w-12 h-12 text-text-secondary mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-text-secondary text-sm mb-2">no tienes reservas próximas</p>
                                <a href="#" class="inline-flex items-center gap-2 text-sm text-brand-primary hover:text-brand-hover font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    crear nueva reserva
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- historial de partidos -->
                    <div class="bg-bg-surface rounded-xl shadow-md p-6 border border-border">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <p class="text-xs uppercase tracking-wider text-text-secondary mb-1 font-semibold">actividad</p>
                                <h3 class="text-lg font-bold text-text-primary">historial de partidos</h3>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-brand-primary/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="bg-bg-secondary/30 rounded-xl p-6 border-2 border-dashed border-border text-center">
                            <svg class="w-12 h-12 text-text-secondary mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <p class="text-text-secondary">aún no has jugado partidos</p>
                            <p class="text-text-secondary text-sm mt-1">¡tu historial aparecerá aquí!</p>
                        </div>
                    </div>
                </div>

                <!-- barra lateral -->
                <div class="space-y-6">
                    <!-- estadísticas personales -->
                    <div class="bg-gradient-to-br from-bg-surface to-brand-primary/5 rounded-xl shadow-md p-6 border border-border">
                        <h3 class="text-lg font-bold text-text-primary mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            mis estadísticas
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 rounded-lg bg-bg-secondary/50">
                                <span class="text-sm text-text-secondary">partidos jugados</span>
                                <span class="text-xl font-bold text-text-primary">0</span>
                            </div>
                            <div class="flex justify-between items-center p-3 rounded-lg bg-bg-secondary/50">
                                <span class="text-sm text-text-secondary">horas totales</span>
                                <span class="text-xl font-bold text-text-primary">0</span>
                            </div>
                            <div class="flex justify-between items-center p-3 rounded-lg bg-bg-secondary/50">
                                <span class="text-sm text-text-secondary">canchas favoritas</span>
                                <span class="text-xl font-bold text-text-primary">—</span>
                            </div>
                        </div>
                    </div>

                    <!-- accesos rápidos -->
                    <div class="bg-bg-surface rounded-xl shadow-md p-6 border border-border">
                        <h3 class="text-lg font-bold text-text-primary mb-4">accesos rápidos</h3>
                        <div class="space-y-2">
                            <a href="#" class="block px-4 py-3 rounded-lg border border-border text-text-primary hover:bg-bg-secondary hover:border-brand-primary/50 transition-all duration-200 flex items-center gap-3 group">
                                <svg class="w-4 h-4 text-text-secondary group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm">ver calendario</span>
                            </a>
                            <a href="#" class="block px-4 py-3 rounded-lg border border-border text-text-primary hover:bg-bg-secondary hover:border-brand-primary/50 transition-all duration-200 flex items-center gap-3 group">
                                <svg class="w-4 h-4 text-text-secondary group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <span class="text-sm">ver canchas disponibles</span>
                            </a>
                            <a href="{{ url('/profile') }}" class="block px-4 py-3 rounded-lg border border-border text-text-primary hover:bg-bg-secondary hover:border-brand-primary/50 transition-all duration-200 flex items-center gap-3 group">
                                <svg class="w-4 h-4 text-text-secondary group-hover:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm">mi perfil</span>
                            </a>
                        </div>
                    </div>

                    <!-- ayuda y soporte -->
                    <div class="bg-gradient-to-br from-brand-primary/10 to-brand-accent/10 rounded-xl shadow-md p-6 border border-brand-primary/20">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-brand-primary/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-text-primary mb-1">¿necesitas ayuda?</h4>
                                <p class="text-sm text-text-secondary mb-3">estamos aquí para ayudarte</p>
                                <a href="#" class="inline-flex items-center gap-1 text-sm text-brand-primary hover:text-brand-hover font-medium">
                                    contactar soporte
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
