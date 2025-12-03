<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cancha;
use App\Models\Cliente;
use App\Models\EstadoReserva;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $canchas = Cancha::where('disponible', true)->pluck('nombre', 'id');
        $estados = EstadoReserva::pluck('nombre', 'id');
        $isAdmin = auth()->user()?->hasRole('administrador');
        $dashboardRoute = $isAdmin ? 'admin.dashboard' : 'empleado.dashboard';

        return view('admin.reservas.index', compact('reservas', 'canchas', 'estados', 'isAdmin', 'dashboardRoute'));
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
        $data = $this->validateData($request, false);
        $data['precio_total'] = $this->calcularPrecio($data['cancha_id'], $data['duracion_horas']);
        Reserva::create($data);

        $redirectRoute = auth()->user()?->hasRole('empleado')
            ? 'empleado.dashboard'
            : 'reservas.index';

        return redirect()->route($redirectRoute)->with('success', 'Reserva creada correctamente.');
    }

    public function show(Reserva $reserva)
    {
        $reserva->load(['cancha', 'cliente', 'estado']);
        $isAdmin = auth()->user()?->hasRole('administrador');

        return view('admin.reservas.show', compact('reserva', 'isAdmin'));
    }

    public function edit(Reserva $reserva)
    {
        $this->ensureOnlyAdmins();

        $canchas = Cancha::pluck('nombre', 'id');
        $clientes = Cliente::pluck('nombre', 'id');
        $estados = EstadoReserva::pluck('nombre', 'id');

        return view('admin.reservas.edit', compact('reserva', 'canchas', 'clientes', 'estados'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        $this->ensureOnlyAdmins();

        $data = $this->validateData($request);
        $data['precio_total'] = $this->calcularPrecio($data['cancha_id'], $data['duracion_horas']);
        $reserva->update($data);

        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    public function destroy(Reserva $reserva)
    {
        $this->ensureOnlyAdmins();

        $reserva->delete();
        return redirect()->route('reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }

    private function validateData(Request $request, bool $requireAvailable = true): array
    {
        $canchaRule = Rule::exists('canchas', 'id');

        if ($requireAvailable) {
            $canchaRule = $canchaRule->where('disponible', true);
        }

        return $request->validate([
            'cancha_id' => ['required', $canchaRule],
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

    private function ensureOnlyAdmins(): void
    {
        if (auth()->user()?->hasRole('empleado')) {
            abort(403, 'Esta acción está limitada a administradores.');
        }
    }
}
