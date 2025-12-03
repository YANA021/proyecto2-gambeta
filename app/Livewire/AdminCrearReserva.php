<?php

namespace App\Livewire;

use App\Models\Cancha;
use App\Models\Cliente;
use App\Models\EstadoReserva;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminCrearReserva extends Component
{
    public bool $show = false;
    public ?int $cancha_id = null;
    public ?int $cliente_id = null;
    public string $fecha = '';
    public string $hora_inicio = '';
    public int $duracion_horas = 1;
    public ?int $estado_id = null;
    public float $precio_total = 0;

    public $canchas;
    public $clientes;
    public $estados;

    #[On('openModalReserva')]
    public function open(): void
    {
        $this->resetValidation();
        $this->fecha = now()->format('Y-m-d');
        $this->hora_inicio = '';
        $this->duracion_horas = 1;
        $this->show = true;
        $this->calcularPrecio();
    }

    public function mount(): void
    {
        $this->canchas = Cancha::where('disponible', true)->orderBy('nombre')->get();
        $this->clientes = Cliente::orderBy('nombre')->get();
        $this->estados = EstadoReserva::orderBy('nombre')->get();
        $this->fecha = now()->format('Y-m-d');
    }

    public function updatedCanchaId(): void
    {
        $this->calcularPrecio();
    }

    public function updatedDuracionHoras(): void
    {
        $this->calcularPrecio();
    }

    public function save(): void
    {
        $data = $this->validate([
            'cancha_id' => ['required', Rule::exists('canchas', 'id')->where('disponible', true)],
            'cliente_id' => ['required', 'exists:clientes,id'],
            'fecha' => ['required', 'date'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'duracion_horas' => ['required', 'integer', 'min:1'],
            'estado_id' => ['required', 'exists:estados_reserva,id'],
        ]);

        $this->calcularPrecio();
        $data['precio_total'] = $this->precio_total;

        // validar choques básicos
        $horaFin = Carbon::parse($this->hora_inicio)->addHours((int)$this->duracion_horas)->format('H:i');
        $conflicto = Reserva::where('cancha_id', $this->cancha_id)
            ->whereDate('fecha', $this->fecha)
            ->where(function($query) use ($horaFin) {
                $query->where(function($q) use ($horaFin) {
                    $q->where('hora_inicio', '<', $horaFin)
                      ->whereRaw('ADDTIME(hora_inicio, SEC_TO_TIME(duracion_horas * 3600)) > ?', [$this->hora_inicio]);
                });
            })
            ->exists();

        if ($conflicto) {
            $this->addError('hora_inicio', 'Ya existe una reserva en ese horario para la cancha seleccionada.');
            return;
        }

        Reserva::create($data);

        session()->flash('success', 'Reserva creada correctamente');
        $this->reset(['cancha_id', 'cliente_id', 'hora_inicio', 'duracion_horas', 'estado_id']);
        $this->fecha = now()->format('Y-m-d');
        $this->show = false;
        $this->dispatch('reservaCreada');
    }

    private function calcularPrecio(): void
    {
        $cancha = $this->cancha_id ? $this->canchas->firstWhere('id', $this->cancha_id) : null;
        $precio = $cancha?->precio_hora ?? 0;
        $this->precio_total = (float) ($precio * ($this->duracion_horas ?: 0));
    }

    public function render()
    {
        return view('livewire.admin-crear-reserva');
    }
}
