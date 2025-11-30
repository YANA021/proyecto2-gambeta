<?php

namespace App\Http\Controllers;

use App\Models\EstadoReserva;
use Illuminate\Http\Request;

class EstadoReservaController extends Controller
{
    public function index()
    {
        $estados = EstadoReserva::latest()->paginate(10);
        return view('admin.estados_reserva.index', compact('estados'));
    }

    public function create()
    {
        return view('admin.estados_reserva.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:estados_reserva,nombre'],
        ]);

        EstadoReserva::create($data);

        return redirect()->route('estados_reserva.index')->with('success', 'Estado creado correctamente.');
    }

    public function show(EstadoReserva $estados_reserva)
    {
        return view('admin.estados_reserva.show', ['estado' => $estados_reserva]);
    }

    public function edit(EstadoReserva $estados_reserva)
    {
        return view('admin.estados_reserva.edit', ['estado' => $estados_reserva]);
    }

    public function update(Request $request, EstadoReserva $estados_reserva)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:estados_reserva,nombre,' . $estados_reserva->id],
        ]);

        $estados_reserva->update($data);

        return redirect()->route('estados_reserva.index')->with('success', 'Estado actualizado correctamente.');
    }

    public function destroy(EstadoReserva $estados_reserva)
    {
        $estados_reserva->delete();

        return redirect()->route('estados_reserva.index')->with('success', 'Estado eliminado correctamente.');
    }
}
