<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <p class="text-xs uppercase tracking-[0.3em] text-text-secondary">panel empleado</p>
            <h2 class="text-xl font-semibold text-text-primary leading-tight">
                {{ __('operaciones diarias') }}
            </h2>
        </div>
    </x-slot>

    @php
        $user = auth()->user();
        $userName = $user->nombre_usuario ?? $user->name ?? 'Empleado';
    @endphp

    <div class="py-8">
        <div class="max-w-6xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('reservas.create') }}" class="group rounded-2xl border border-border bg-gradient-to-br from-brand-primary/10 to-brand-accent/5 p-4 shadow-sm hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-text-secondary">acciones</p>
                            <p class="text-lg font-bold text-text-primary">Crear reserva</p>
                        </div>
                        <span class="rounded-full bg-brand-primary/15 px-3 py-2 text-brand-primary text-xs font-semibold uppercase group-hover:scale-105 transition">CR</span>
                    </div>
                    <p class="mt-2 text-sm text-text-secondary">Registrar una nueva reserva rápidamente.</p>
                </a>
                <a href="{{ route('pagos.create') }}" class="group rounded-2xl border border-border bg-gradient-to-br from-emerald-100/40 to-emerald-50 p-4 shadow-sm hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-emerald-700/70">caja</p>
                            <p class="text-lg font-bold text-emerald-800">Registrar pago</p>
                        </div>
                        <span class="rounded-full bg-white px-3 py-2 text-emerald-700 text-xs font-semibold uppercase group-hover:scale-105 transition">CO</span>
                    </div>
                    <p class="mt-2 text-sm text-emerald-700/80">Asienta cobros de reservas confirmadas.</p>
                </a>
                <a href="{{ route('pagos.index') }}" class="group rounded-2xl border border-border bg-white p-4 shadow-sm hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-text-secondary">pagos</p>
                            <p class="text-lg font-bold text-text-primary">Ver / modificar</p>
                        </div>
                        <span class="rounded-full bg-brand-primary/10 px-3 py-2 text-brand-primary text-xs font-semibold uppercase group-hover:scale-105 transition">PG</span>
                    </div>
                    <p class="mt-2 text-sm text-text-secondary">Edita pagos existentes cuando sea necesario.</p>
                </a>
                <a href="{{ route('reservas.calendar') }}" class="group rounded-2xl border border-border bg-white p-4 shadow-sm hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-text-secondary">agenda</p>
                            <p class="text-lg font-bold text-text-primary">Calendario</p>
                        </div>
                        <span class="rounded-full bg-brand-primary/10 px-3 py-2 text-brand-primary text-xs font-semibold uppercase group-hover:scale-105 transition">AG</span>
                    </div>
                    <p class="mt-2 text-sm text-text-secondary">Consulta disponibilidad general.</p>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-2xl border border-border bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-text-secondary">reservas hoy</p>
                    <p class="mt-1 text-3xl font-bold text-text-primary">{{ $stats['reservas_hoy'] }}</p>
                </div>
                <div class="rounded-2xl border border-border bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-text-secondary">pendientes</p>
                    <p class="mt-1 text-3xl font-bold text-amber-600">{{ $stats['reservas_pendientes'] }}</p>
                </div>
                <div class="rounded-2xl border border-border bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-text-secondary">ingresos hoy</p>
                    <p class="mt-1 text-3xl font-bold text-emerald-600">${{ number_format($stats['ingresos_hoy'], 2) }}</p>
                </div>
                <div class="rounded-2xl border border-border bg-white p-4 shadow-sm">
                    <p class="text-xs uppercase tracking-wide text-text-secondary">clientes</p>
                    <p class="mt-1 text-3xl font-bold text-text-primary">{{ $stats['clientes_total'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-4">
                    <div class="rounded-2xl border border-border bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-text-secondary">hoy</p>
                                <h3 class="text-lg font-bold text-text-primary">Reservas programadas</h3>
                            </div>
                            <a href="{{ route('reservas.create') }}" class="text-sm font-semibold text-brand-primary hover:text-brand-hover">+ nueva</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="text-xs uppercase tracking-wide text-text-secondary border-b border-border">
                                    <tr>
                                        <th class="pb-3">Hora</th>
                                        <th class="pb-3">Cliente</th>
                                        <th class="pb-3">Cancha</th>
                                        <th class="pb-3">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @forelse($reservasHoy as $reserva)
                                        <tr class="text-text-primary">
                                            <td class="py-3 font-semibold">{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin ?? '' }}</td>
                                            <td class="py-3">{{ $reserva->cliente->nombre ?? 'n/d' }}</td>
                                            <td class="py-3">{{ $reserva->cancha->nombre ?? 'n/d' }}</td>
                                            <td class="py-3">
                                                <span class="rounded-full px-3 py-1 text-xs font-semibold
                                                    {{ ($reserva->estado->nombre ?? '') === 'Confirmada' ? 'bg-emerald-100 text-emerald-700' :
                                                       (($reserva->estado->nombre ?? '') === 'Pendiente' ? 'bg-amber-100 text-amber-700' :
                                                       'bg-slate-100 text-slate-600') }}">
                                                    {{ $reserva->estado->nombre ?? 'pendiente' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-6 text-center text-text-secondary">No hay reservas registradas para hoy.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-border bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-text-secondary">pagos</p>
                                <h3 class="text-lg font-bold text-text-primary">Guías rápidas</h3>
                            </div>
                        </div>
                        <ul class="space-y-3 text-sm text-text-secondary">
                            <li class="flex items-start gap-2">
                                <span class="mt-1 text-brand-primary">•</span>
                                Verifica que la reserva esté confirmada antes de registrar el pago.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-1 text-brand-primary">•</span>
                                Puedes modificar un pago desde el listado si cambió el método o monto.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-1 text-brand-primary">•</span>
                                Las anulaciones las gestiona exclusivamente un administrador.
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-border bg-white p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.2em] text-text-secondary">mi sesión</p>
                        <h3 class="text-lg font-bold text-text-primary mt-2">{{ $userName }}</h3>
                        <p class="text-sm text-text-secondary">Rol: empleado</p>
                        <div class="mt-4 flex flex-col gap-3">
                            <a href="{{ route('pagos.index') }}" class="rounded-lg border border-border px-4 py-2 text-sm font-semibold text-text-primary hover:bg-bg-secondary">
                                Ver pagos
                            </a>
                            <a href="{{ route('clientes.index') }}" class="rounded-lg border border-border px-4 py-2 text-sm font-semibold text-text-primary hover:bg-bg-secondary">
                                Listado de clientes
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700">
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.2em] text-amber-600">recordatorio</p>
                        <p class="mt-2 text-sm text-amber-800">Los empleados no pueden eliminar registros ni actualizar precios de canchas. Cualquier ajuste debe solicitarse al administrador.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
