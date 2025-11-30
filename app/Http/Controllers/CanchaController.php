<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\TipoCancha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CanchaController extends Controller
{
    public function index()
    {
        $canchas = Cancha::with('tipoCancha')->latest()->paginate(10);

        return view('admin.canchas.index', compact('canchas'));
    }

    public function create()
    {
        $tipos = TipoCancha::pluck('nombre', 'id');

        return view('admin.canchas.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('canchas', 'public');
        }

        Cancha::create($data);

        return redirect()->route('canchas.index')->with('success', 'Cancha creada correctamente.');
    }

    public function show(Cancha $cancha)
    {
        $cancha->load('tipoCancha');

        return view('admin.canchas.show', compact('cancha'));
    }

    public function edit(Cancha $cancha)
    {
        $tipos = TipoCancha::pluck('nombre', 'id');

        return view('admin.canchas.edit', compact('cancha', 'tipos'));
    }

    public function update(Request $request, Cancha $cancha)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('foto')) {
            if ($cancha->foto) {
                Storage::disk('public')->delete($cancha->foto);
            }
            $data['foto'] = $request->file('foto')->store('canchas', 'public');
        }

        $cancha->update($data);

        return redirect()->route('canchas.index')->with('success', 'Cancha actualizada correctamente.');
    }

    public function destroy(Cancha $cancha)
    {
        if ($cancha->foto) {
            Storage::disk('public')->delete($cancha->foto);
        }

        $cancha->delete();

        return redirect()->route('canchas.index')->with('success', 'Cancha eliminada correctamente.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'tipo_id' => ['required', 'exists:tipo_canchas,id'],
            'precio_hora' => ['required', 'numeric', 'min:0'],
            'disponible' => ['required', 'boolean'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
