<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cancha;
use App\Models\Cliente;
use App\Models\EstadoReserva;
use App\Models\BloqueoHorario;
use Carbon\Carbon;
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
        $this->validarConflictos($data);
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
        return view('admin.reservas.show', compact('reserva'));
    }

    public function edit(Reserva $reserva)
    {
        // los empleados solo deberían cambiar el estado, no editar todo
        if (auth()->user()?->hasRole('empleado')) {
            return redirect()->route('reservas.show', $reserva)->withErrors(['error' => 'Solo puedes cambiar el estado desde el detalle.']);
        }

        $canchas = Cancha::pluck('nombre', 'id');
        $clientes = Cliente::pluck('nombre', 'id');
        $estados = EstadoReserva::pluck('nombre', 'id');

        return view('admin.reservas.edit', compact('reserva', 'canchas', 'clientes', 'estados'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        // empleados: solo pueden cambiar estado
        if (auth()->user()?->hasRole('empleado')) {
            $data = $this->validateEstado($request);
            $reserva->update(['estado_id' => $data['estado_id']]);
            return redirect()->route('reservas.index')->with('success', 'Estado de la reserva actualizado.');
        }

        $data = $this->validateData($request);
        $this->validarConflictos($data, $reserva->id);
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

    private function ensureOnlyAdmins(): void
    {
        if (auth()->user()?->hasRole('empleado')) {
            abort(403, 'Esta acción está limitada a administradores.');
        }
    }

    private function validarConflictos(array $data, ?int $ignoreId = null): void
    {
        $horaInicio = $data['hora_inicio'];
        $horaFin = Carbon::parse($horaInicio)->addHours((int)$data['duracion_horas'])->format('H:i:s');

        // bloqueos de horario
        $bloqueado = BloqueoHorario::where('cancha_id', $data['cancha_id'])
            ->where('fecha', $data['fecha'])
            ->where(function ($q) use ($horaInicio, $horaFin) {
                $q->whereBetween('hora_inicio', [$horaInicio, $horaFin])
                  ->orWhereBetween('hora_fin', [$horaInicio, $horaFin])
                  ->orWhere(function ($sq) use ($horaInicio, $horaFin) {
                      $sq->where('hora_inicio', '<=', $horaInicio)
                         ->where('hora_fin', '>=', $horaFin);
                  });
            })
            ->exists();

        if ($bloqueado) {
            back()->withErrors(['hora_inicio' => 'Horario bloqueado por mantenimiento/evento'])->throwResponse();
        }

        // choques con otras reservas (excepto canceladas: estado_id=3)
        $conflicto = Reserva::where('cancha_id', $data['cancha_id'])
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where('fecha', $data['fecha'])
            ->whereHas('estado', fn($q) => $q->where('id', '!=', 3))
            ->where(function($query) use ($horaInicio, $horaFin) {
                $query->where(function($q) use ($horaInicio, $horaFin) {
                    $q->where('hora_inicio', '<', $horaFin)
                      ->whereRaw('ADDTIME(hora_inicio, SEC_TO_TIME(duracion_horas * 3600)) > ?', [$horaInicio]);
                });
            })
            ->exists();

        if ($conflicto) {
            back()->withErrors(['hora_inicio' => 'Ya existe una reserva en ese horario para esta cancha'])->throwResponse();
        }
    }

    private function validateEstado(Request $request): array
    {
        return $request->validate([
            'estado_id' => ['required', 'exists:estados_reserva,id'],
        ]);
    }
}
