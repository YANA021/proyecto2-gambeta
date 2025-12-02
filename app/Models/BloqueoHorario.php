<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloqueoHorario extends Model
{
    protected $table = 'bloqueo_horarios';

    protected $fillable = [
        'cancha_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'motivo',
        'created_by'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function cancha(): BelongsTo
    {
        return $this->belongsTo(Cancha::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }
}
