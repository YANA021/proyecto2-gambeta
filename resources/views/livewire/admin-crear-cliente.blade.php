<div>
    @if ($show)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
            <div class="w-full max-w-xl rounded-2xl bg-white p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-text-secondary">clientes</p>
                        <h3 class="text-xl font-bold text-text-primary">Nuevo cliente</h3>
                    </div>
                    <button wire:click="$set('show', false)" class="text-text-secondary hover:text-text-primary">✕</button>
                </div>
                <form wire:submit.prevent="save" class="space-y-4">
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Nombre</label>
                            <input type="text" wire:model="nombre" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                            @error('nombre') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Teléfono</label>
                            <input type="text" wire:model="telefono" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                            @error('telefono') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Equipo / Grupo (opcional)</label>
                            <select wire:model="grupo_id" class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                                <option value="">Sin grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('grupo_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" wire:click="$set('show', false)" class="px-4 py-2 rounded-lg border border-border text-text-secondary hover:bg-bg-secondary">Cancelar</button>
                        <button type="submit" class="px-5 py-2 rounded-lg bg-brand-primary text-white font-semibold hover:bg-brand-hover">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
