<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::latest()->paginate(10);
        return view('admin.grupos.index', compact('grupos'));
    }

    public function create()
    {
        return view('admin.grupos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
        ]);

        Grupo::create($data);

        return redirect()->route('grupos.index')->with('success', 'Grupo creado correctamente.');
    }

    public function show(Grupo $grupo)
    {
        return view('admin.grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        return view('admin.grupos.edit', compact('grupo'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
        ]);

        $grupo->update($data);

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();

        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado correctamente.');
    }
}
