<div>
    @if ($show)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
            <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-text-secondary">canchas</p>
                        <h3 class="text-xl font-bold text-text-primary">Nueva cancha</h3>
                    </div>
                    <button wire:click="$set('show', false)" class="text-text-secondary hover:text-text-primary">✕</button>
                </div>
                <form wire:submit.prevent="save" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Nombre</label>
                            <input type="text" wire:model="nombre" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                            @error('nombre') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Tipo</label>
                            <select wire:model="tipo_id" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                                <option value="">Seleccione...</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('tipo_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-text-primary">Precio por hora</label>
                            <input type="number" step="0.01" wire:model="precio_hora" required class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                            @error('precio_hora') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex items-center gap-2 mt-6">
                            <input type="checkbox" wire:model="disponible" class="rounded border-border text-brand-primary">
                            <label class="text-sm text-text-secondary">Disponible</label>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm font-semibold text-text-primary">Foto (opcional)</label>
                            <input type="file" wire:model="foto" class="w-full rounded-lg border border-border px-3 py-2 text-sm">
                            @error('foto') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
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
