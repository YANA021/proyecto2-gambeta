<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo_id',
        'precio_hora',
        'disponible',
        'foto',
    ];

    protected $casts = [
        'disponible' => 'boolean',
        'precio_hora' => 'decimal:2',
    ];

    public function tipoCancha()
    {
        return $this->belongsTo(TipoCancha::class, 'tipo_id');
    }
}
