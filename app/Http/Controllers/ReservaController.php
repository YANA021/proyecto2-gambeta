<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cancha;
use App\Models\Cliente;
use App\Models\EstadoReserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        $query = Reserva::with(['cancha', 'cliente', 'estado']);

        if (request('fecha')) {
            $query->whereDate('fecha', request('fecha'));
        }

        if (request('cancha_id')) {
            $query->where('cancha_id', request('cancha_id'));
        }

        if (request('estado_id')) {
            $query->where('estado_id', request('estado_id'));
        }

        $reservas = $query->latest()->paginate(10);
        
        $canchas = Cancha::pluck('nombre', 'id');
        $estados = EstadoReserva::pluck('nombre', 'id');

        return view('admin.reservas.index', compact('reservas', 'canchas', 'estados'));
    }

    public function create()
    {
        $canchas = Cancha::pluck('nombre', 'id');
        $clientes = Cliente::pluck('nombre', 'id');
        $estados = EstadoReserva::pluck('nombre', 'id');

        return view('admin.reservas.create', compact('canchas', 'clientes', 'estados'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['precio_total'] = $this->calcularPrecio($data['cancha_id'], $data['duracion_horas']);
        Reserva::create($data);

        return redirect()->route('reservas.index')->with('success', 'Reserva creada correctamente.');
    }

    public function show(Reserva $reserva)
    {
        $reserva->load(['cancha', 'cliente', 'estado']);
        return view('admin.reservas.show', compact('reserva'));
    }

    public function edit(Reserva $reserva)
    {
        $canchas = Cancha::pluck('nombre', 'id');
        $clientes = Cliente::pluck('nombre', 'id');
        $estados = EstadoReserva::pluck('nombre', 'id');

        return view('admin.reservas.edit', compact('reserva', 'canchas', 'clientes', 'estados'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        $data = $this->validateData($request);
        $data['precio_total'] = $this->calcularPrecio($data['cancha_id'], $data['duracion_horas']);
        $reserva->update($data);

        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    public function destroy(Reserva $reserva)
    {
        if (auth()->user()->hasRole('empleado')) {
            abort(403, 'No autorizado para eliminar reservas');
        }

        $reserva->delete();
        return redirect()->route('reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'cancha_id' => ['required', 'exists:canchas,id'],
            'cliente_id' => ['required', 'exists:clientes,id'],
            'fecha' => ['required', 'date'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'duracion_horas' => ['required', 'integer', 'min:1'],
            'estado_id' => ['required', 'exists:estados_reserva,id'],
        ]);
    }

    private function calcularPrecio(int $canchaId, int $duracionHoras): float
    {
        $cancha = Cancha::find($canchaId);
        $precioHora = $cancha?->precio_hora ?? 0;
        return (float) ($precioHora * $duracionHoras);
    }
}
