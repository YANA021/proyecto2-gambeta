<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'cancha_id',
        'cliente_id',
        'fecha',
        'hora_inicio',
        'duracion_horas',
        'estado_id',
        'precio_total',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoReserva::class, 'estado_id');
    }
}
