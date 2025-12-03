<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Cancha;
use App\Models\EstadoReserva;
use Illuminate\Validation\Rule;

class CrearReserva extends Component
{
    public $cancha_id;
    public $cliente_id;
    public $fecha;
    public $hora_inicio;
    public $duracion_horas = 1;
    public $precio_total = 0;

    public $canchas;
    public $clientes;
    public $estados;

    // para crear cliente rápido
    public $showModalCliente = false;
    public $nuevoClienteNombre;
    public $nuevoClienteTelefono;
    public $nuevoClienteGrupo;

    protected function rules(): array
    {
        return [
            'cancha_id' => [
                'required',
                Rule::exists('canchas', 'id')->where('disponible', true),
            ],
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required',
            'duracion_horas' => 'required|integer|min:1|max:8',
        ];
    }

    public function mount($cancha_id = null, $fecha = null, $hora = null)
    {
        $this->cancha_id = $cancha_id;
        $this->fecha = $fecha ?? now()->format('Y-m-d');
        $this->hora_inicio = $hora;

        $this->canchas = Cancha::where('disponible', true)->get();
        $this->clientes = Cliente::orderBy('nombre')->get();
        $this->estados = EstadoReserva::all();

        if ($this->cancha_id) {
            $this->calcularPrecio();
        }
    }

    public function updatedDuracionHoras()
    {
        $this->calcularPrecio();
    }

    public function updatedCanchaId()
    {
        $this->calcularPrecio();
    }

    public function calcularPrecio()
    {
        if ($this->cancha_id && $this->duracion_horas) {
            $cancha = Cancha::find($this->cancha_id);
            if ($cancha) {
                $this->precio_total = $cancha->precio_hora * $this->duracion_horas;
            }
        }
    }

    public function abrirModalCliente()
    {
        $this->showModalCliente = true;
    }

    public function cerrarModalCliente()
    {
        $this->showModalCliente = false;
        $this->reset(['nuevoClienteNombre', 'nuevoClienteTelefono', 'nuevoClienteGrupo']);
    }

    public function guardarClienteRapido()
    {
        $this->validate([
            'nuevoClienteNombre' => 'required|string|max:255',
            'nuevoClienteTelefono' => 'required|string|max:20',
        ]);

        $cliente = Cliente::create([
            'nombre' => $this->nuevoClienteNombre,
            'telefono' => $this->nuevoClienteTelefono,
            'grupo_id' => $this->nuevoClienteGrupo,
        ]);

        $this->cliente_id = $cliente->id;
        $this->clientes = Cliente::orderBy('nombre')->get();
        $this->cerrarModalCliente();
    }

    public function guardarReserva()
    {
        $this->validate();

        // validar bloqueos
        $bloqueado = \App\Models\BloqueoHorario::where('cancha_id', $this->cancha_id)
            ->where('fecha', $this->fecha)
            ->where(function($query) {
                $horaFin = \Carbon\Carbon::parse($this->hora_inicio)
                    ->addHours((int)$this->duracion_horas)->format('H:i:s');
                
                $query->where(function($q) use ($horaFin) {
                    $q->whereBetween('hora_inicio', [$this->hora_inicio, $horaFin])
                      ->orWhereBetween('hora_fin', [$this->hora_inicio, $horaFin])
                      ->orWhere(function($sq) use ($horaFin) {
                          $sq->where('hora_inicio', '<=', $this->hora_inicio)
                             ->where('hora_fin', '>=', $horaFin);
                      });
                });
            })
            ->exists();

        if ($bloqueado) {
            session()->flash('error', 'No se puede reservar: horario bloqueado por mantenimiento/evento');
            return;
        }

        // validar disponibilidad
        $conflicto = Reserva::where('cancha_id', $this->cancha_id)
            ->where('fecha', $this->fecha)
            ->where('estado_id', '!=', 3) // ignorar canceladas
            ->where(function($query) {
                $horaFin = \Carbon\Carbon::parse($this->hora_inicio)
                    ->addHours((int)$this->duracion_horas)->format('H:i');

                $query->where(function($q) use ($horaFin) {
                    $q->where('hora_inicio', '<', $horaFin)
                      ->whereRaw('ADDTIME(hora_inicio, SEC_TO_TIME(duracion_horas * 3600)) > ?', [$this->hora_inicio]);
                });
            })
            ->exists();

        if ($conflicto) {
            session()->flash('error', 'Ya existe una reserva en este horario');
            return;
        }

        // crear reserva
        $estadoPendiente = EstadoReserva::where('nombre', 'Pendiente')->first();

        Reserva::create([
            'cancha_id' => $this->cancha_id,
            'cliente_id' => $this->cliente_id,
            'fecha' => $this->fecha,
            'hora_inicio' => $this->hora_inicio,
            'duracion_horas' => $this->duracion_horas,
            'precio_total' => $this->precio_total,
            'estado_id' => $estadoPendiente->id ?? 1,
        ]);

        session()->flash('success', 'Reserva creada exitosamente');

        $redirectRoute = auth()->user()?->hasRole('empleado') ? 'empleado.dashboard' : 'reservas.index';
        return redirect()->route($redirectRoute);
    }

    public function render()
    {
        return view('livewire.crear-reserva');
    }
}
