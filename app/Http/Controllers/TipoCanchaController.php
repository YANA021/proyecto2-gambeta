<?php

namespace App\Http\Controllers;

use App\Models\TipoCancha;
use Illuminate\Http\Request;

class TipoCanchaController extends Controller
{
    public function index()
    {
        $tiposCanchas = TipoCancha::all();
        return view('admin.tipo_canchas.index', compact('tiposCanchas'));
    }


    public function create()
    {
        return view('admin.tipo_canchas.create');
    }


    public function store(Request $request)
    {
        $validado = $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_canchas,nombre',
        ]);

        TipoCancha::create($validado);

        return redirect()->route('tipo_canchas.index')->with('success', 'Tipo de cancha creado exitosamente.');
    }

    public function show(TipoCancha $tipoCancha)
    {
        return view('admin.tipo_canchas.show', compact('tipoCancha'));
    }


    public function edit(TipoCancha $tipoCancha)
    {
        return view('admin.tipo_canchas.edit', compact('tipoCancha'));
    }


    public function update(Request $request, TipoCancha $tipoCancha)
    {
        $validado = $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_canchas,nombre,' . $tipoCancha->id,
        ]);

        $tipoCancha->update($validado);

        return redirect()->route('tipo_canchas.index')->with('success', 'Tipo de cancha actualizado exitosamente.');
    }


    public function destroy(TipoCancha $tipoCancha)
    {
        $tipoCancha->delete();

        return redirect()->route('tipo_canchas.index')->with('success', 'Tipo de cancha eliminado exitosamente.');
    }
}