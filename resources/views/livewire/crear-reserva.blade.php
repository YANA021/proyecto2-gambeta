<div>
    @if (session('error'))
        <div class="mb-4 rounded-lg bg-rose-100 p-4 text-rose-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Formulario -->
        <div class="lg:col-span-2">
            <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
                <h2 class="mb-6 text-lg font-bold text-slate-800">Detalles de la Reserva</h2>
                
                <div class="space-y-4">
                    <!-- Cancha -->
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Cancha</label>
                        <select wire:model.live="cancha_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                            <option value="">Seleccione una cancha...</option>
                            @foreach($canchas as $cancha)
                                <option value="{{ $cancha->id }}">{{ $cancha->nombre }} (${{ $cancha->precio_hora }}/h)</option>
                            @endforeach
                        </select>
                        @error('cancha_id') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Cliente -->
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Cliente</label>
                        <div class="flex gap-2">
                            <select wire:model.live="cliente_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                                <option value="">Seleccione un cliente...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                            <button wire:click="abrirModalCliente" class="rounded-lg bg-slate-100 px-3 py-2 text-slate-700 hover:bg-slate-200">
                                +
                            </button>
                        </div>
                        @error('cliente_id') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <!-- Fecha -->
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Fecha</label>
                            <input type="date" wire:model.live="fecha" min="{{ now()->format('Y-m-d') }}"
                                   class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                            @error('fecha') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Hora -->
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Hora Inicio</label>
                            <input type="time" wire:model.live="hora_inicio"
                                   class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                            @error('hora_inicio') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Duración -->
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Duración (horas)</label>
                            <input type="number" wire:model.live="duracion_horas" min="1" max="8"
                                   class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                            @error('duracion_horas') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 rounded-xl border border-slate-100 bg-slate-50 p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-bold text-slate-800">Resumen</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Cancha:</span>
                        <span class="font-semibold text-slate-900">
                            {{ $canchas->find($cancha_id)?->nombre ?? '-' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Fecha:</span>
                        <span class="font-semibold text-slate-900">{{ $fecha }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Horario:</span>
                        <span class="font-semibold text-slate-900">
                            {{ $hora_inicio ? $hora_inicio . ' - ' . \Carbon\Carbon::parse($hora_inicio)->addHours((int)$duracion_horas)->format('H:i') : '-' }}
                        </span>
                    </div>
                    
                    <hr class="border-slate-200">
                    
                    <div class="flex justify-between text-lg font-bold">
                        <span class="text-slate-700">Total:</span>
                        <span class="text-emerald-600">${{ number_format($precio_total, 2) }}</span>
                    </div>
                </div>

                <button wire:click="guardarReserva" 
                        class="mt-6 w-full rounded-lg bg-slate-900 py-3 font-bold text-white shadow-lg transition-transform hover:-translate-y-1 hover:bg-slate-800">
                    Confirmar Reserva
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo Cliente -->
    @if($showModalCliente)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-2xl">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold">Nuevo Cliente</h3>
                    <button wire:click="cerrarModalCliente" class="text-slate-400 hover:text-slate-600">✕</button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Nombre</label>
                        <input type="text" wire:model="nuevoClienteNombre" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        @error('nuevoClienteNombre') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Teléfono</label>
                        <input type="text" wire:model="nuevoClienteTelefono" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        @error('nuevoClienteTelefono') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="cerrarModalCliente" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Cancelar</button>
                    <button wire:click="guardarClienteRapido" class="rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600">Guardar Cliente</button>
                </div>
            </div>
        </div>
    @endif
</div>
