<div class="space-y-6">
    <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
        <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-end">
            <div class="flex-1">
                <label class="mb-1 block text-sm font-semibold text-slate-700">Fecha</label>
                <input type="date" 
                       wire:model.live="fecha" 
                       min="{{ now()->format('Y-m-d') }}"
                       class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
            </div>
            
            <div class="flex-1">
                <label class="mb-1 block text-sm font-semibold text-slate-700">Cancha</label>
                <select wire:model.live="cancha_id" 
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                    @foreach($canchas as $cancha)
                        <option value="{{ $cancha->id }}">
                            {{ $cancha->nombre }} - ${{ number_format($cancha->precio_hora, 2) }}/h
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">Horarios Disponibles</h3>
            
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                @foreach($horariosDisponibles as $slot)
                    <button 
                        wire:click="seleccionarHorario('{{ $slot['hora'] }}')"
                        @if(!$slot['disponible']) disabled @endif
                        class="group relative flex flex-col items-center justify-center rounded-xl border p-4 transition-all
                        @if($slot['bloqueado'] ?? false)
                            cursor-not-allowed border-rose-200 bg-rose-50 opacity-75
                        @elseif($slot['disponible']) 
                            cursor-pointer border-slate-200 bg-white hover:border-emerald-400 hover:bg-emerald-50 hover:shadow-md
                        @else
                            cursor-not-allowed border-slate-100 bg-slate-50 opacity-60
                        @endif">
                        
                        <span class="text-lg font-bold 
                            @if($slot['bloqueado'] ?? false) text-rose-600
                            @elseif($slot['disponible']) text-slate-700 group-hover:text-emerald-700
                            @else text-slate-400
                            @endif">
                            {{ \Carbon\Carbon::parse($slot['hora'])->format('h:i A') }}
                        </span>
                        
                        <span class="mt-1 text-xs font-medium 
                            @if($slot['bloqueado'] ?? false) text-rose-600
                            @elseif($slot['disponible']) text-emerald-600
                            @else text-rose-500
                            @endif">
                            @if($slot['bloqueado'] ?? false) 🚫 Bloqueado
                            @elseif($slot['disponible']) Disponible
                            @else Ocupado
                            @endif
                        </span>

                        @if($slot['disponible'])
                            <div class="absolute -right-1 -top-1 h-3 w-3 rounded-full bg-emerald-400 opacity-0 transition-opacity group-hover:opacity-100"></div>
                        @endif
                    </button>
                @endforeach
            </div>

            @if(empty($horariosDisponibles))
                <div class="rounded-lg border border-dashed border-slate-200 py-8 text-center text-sm text-slate-500">
                    No hay horarios disponibles para esta fecha.
                </div>
            @endif
        </div>
    </div>
</div>
