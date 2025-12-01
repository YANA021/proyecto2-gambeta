<?php

namespace App\Http\Controllers;

use App\Models\BloqueoHorario;
use App\Models\Cancha;
use Illuminate\Http\Request;

class BloqueoController extends Controller
{
    public function index()
    {
        $bloqueos = BloqueoHorario::with(['cancha', 'creador'])->latest()->paginate(15);
        return view('admin.bloqueos.index', compact('bloqueos'));
    }

    public function create()
    {
        $canchas = Cancha::where('disponible', true)->get();
        return view('admin.bloqueos.create', compact('canchas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cancha_id' => 'required|exists:canchas,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'motivo' => 'required|string|max:255'
        ]);

        $validated['created_by'] = auth()->id();

        BloqueoHorario::create($validated);

        return redirect()->route('bloqueos.index')->with('success', 'Bloqueo creado exitosamente');
    }

    public function destroy(BloqueoHorario $bloqueo)
    {
        $bloqueo->delete();
        return redirect()->route('bloqueos.index')->with('success', 'Bloqueo eliminado');
    }
}
