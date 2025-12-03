<div>
    @if ($show)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 overflow-y-auto">
            <div class="w-full max-w-4xl rounded-2xl bg-white p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-text-secondary">reservas</p>
                        <h3 class="text-xl font-bold text-text-primary">Crear reserva</h3>
                    </div>
                    <button wire:click="$set('show', false)" class="text-text-secondary hover:text-text-primary">✕</button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Cancha</label>
                            <select wire:model="cancha_id" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                                <option value="">Seleccione cancha</option>
                                @foreach($canchas as $cancha)
                                    <option value="{{ $cancha->id }}">{{ $cancha->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cancha_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Cliente</label>
                            <select wire:model="cliente_id" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                                <option value="">Seleccione cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cliente_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Fecha</label>
                            <input type="date" wire:model="fecha" min="{{ now()->format('Y-m-d') }}" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                            @error('fecha') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Hora inicio</label>
                            <input type="time" wire:model="hora_inicio" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                            @error('hora_inicio') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Duración (horas)</label>
                            <input type="number" wire:model="duracion_horas" min="1" value="1" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                            @error('duracion_horas') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Estado</label>
                            <select wire:model="estado_id" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                            @error('estado_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between rounded-lg border border-border bg-bg-secondary/60 px-4 py-3">
                        <div class="text-sm text-text-secondary">Total estimado</div>
                        <div class="text-xl font-bold text-brand-primary">${{ number_format($precio_total, 2) }}</div>
                    </div>

                    @error('hora_inicio') <p class="text-sm text-rose-600">{{ $message }}</p> @enderror

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" wire:click="$set('show', false)" class="px-4 py-2 rounded-lg border border-border text-text-secondary hover:bg-bg-secondary">Cancelar</button>
                        <button type="submit" class="px-5 py-2 rounded-lg bg-brand-primary text-white font-semibold hover:bg-brand-hover">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
