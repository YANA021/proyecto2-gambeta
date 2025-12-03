<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cancha - Gambeta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="mx-auto max-w-3xl px-6 py-10">
        <header class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wide text-slate-500">Editar</p>
                <h1 class="text-2xl font-bold">Cancha #{{ $cancha->id }}</h1>
            </div>
            <a href="{{ route('canchas.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Volver</a>
        </header>

        <div class="rounded-xl border border-slate-100 bg-white p-6 shadow-sm">
            <form action="{{ route('canchas.update', $cancha) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-semibold text-slate-700">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $cancha->nombre) }}" required
                           class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                    @error('nombre') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Tipo</label>
                    <select name="tipo_id" required
                            class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                        <option value="">Seleccione...</option>
                        @foreach($tipos as $id => $nombre)
                            <option value="{{ $id }}" @selected(old('tipo_id', $cancha->tipo_id) == $id)>{{ $nombre }}</option>
                        @endforeach
                    </select>
                    @error('tipo_id') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Precio por hora (USD)</label>
                    <input type="number" step="0.01" min="0" name="precio_hora" value="{{ old('precio_hora', $cancha->precio_hora) }}" required
                           class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none">
                    @error('precio_hora') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="disponible" value="0">
                    <input type="checkbox" name="disponible" value="1" @checked(old('disponible', $cancha->disponible))
                           class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-400">
                    <span class="text-sm text-slate-700">Disponible para reservas</span>
                    @error('disponible') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700">Foto (opcional)</label>
                    <label class="mt-1 relative block rounded-lg border border-dashed border-slate-300 bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-800 cursor-pointer hover:border-slate-400 hover:bg-slate-200 transition">
                        <span class="inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-8h.01M6 20h12a2 2 0 002-2V8a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Escoger una imagen
                        </span>
                        <input type="file" name="foto" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                    </label>
                    @error('foto') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    @if($cancha->foto)
                        <p class="mt-2 text-xs text-slate-500">Foto actual:</p>
                        <img src="{{ Storage::disk('public')->url($cancha->foto) }}" alt="Foto cancha" class="mt-1 h-32 w-full max-w-xs rounded-lg object-cover">
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex w-full justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Actualizar cancha
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
