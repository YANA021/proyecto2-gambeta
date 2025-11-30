<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserva_id',
        'cliente_id',
        'fecha_pago',
        'monto',
        'metodo',
        'estado_pago',
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
