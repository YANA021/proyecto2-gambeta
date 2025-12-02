<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cancha;
use App\Models\Reserva;
use Carbon\Carbon;

class CalendarioReservas extends Component
{
    public $fecha;
    public $cancha_id;
    public $horariosDisponibles = [];
    public $canchas;

    public function mount()
    {
        $this->fecha = now()->format('Y-m-d');
        $this->canchas = Cancha::where('disponible', true)->get();
        
        if ($this->canchas->isNotEmpty()) {
            $this->cancha_id = $this->canchas->first()->id;
        }
        
        $this->cargarHorarios();
    }

    public function updatedFecha()
    {
        $this->cargarHorarios();
    }

    public function updatedCanchaId()
    {
        $this->cargarHorarios();
    }

    public function cargarHorarios()
    {
        if (!$this->cancha_id || !$this->fecha) {
            return;
        }

        // horarios posibles: 8:00 am a 10:00 pm (22:00)
        $horaInicio = 8;
        $horaFin = 22;
        $this->horariosDisponibles = [];

        for ($hora = $horaInicio; $hora < $horaFin; $hora++) {
            $horario = sprintf('%02d:00', $hora);
            
            // verificar si está reservado
            $ocupado = Reserva::where('cancha_id', $this->cancha_id)
                ->where('fecha', $this->fecha)
                ->where('estado_id', '!=', 3) // ignorar canceladas
                ->where(function ($query) use ($horario) {
                    $query->where('hora_inicio', '<', \Carbon\Carbon::parse($horario)->addHours(1)->format('H:i:s'))
                          ->whereRaw('ADDTIME(hora_inicio, SEC_TO_TIME(duracion_horas * 3600)) > ?', [$horario]);
                })
                ->exists();

            // verificar si está bloqueado
            $bloqueado = \App\Models\BloqueoHorario::where('cancha_id', $this->cancha_id)
                ->where('fecha', $this->fecha)
                ->where('hora_inicio', '<=', $horario . ':00')
                ->where('hora_fin', '>', $horario . ':00')
                ->exists();

            $this->horariosDisponibles[] = [
                'hora' => $horario,
                'disponible' => !$ocupado && !$bloqueado,
                'bloqueado' => $bloqueado
            ];
        }
    }

    public function seleccionarHorario($hora)
    {
        return redirect()->route('reservas.create', [
            'cancha_id' => $this->cancha_id,
            'fecha' => $this->fecha,
            'hora' => $hora
        ]);
    }

    public function render()
    {
        return view('livewire.calendario-reservas');
    }
}
