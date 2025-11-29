<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCancha extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * @var string
     */
    protected $table = 'tipo_canchas';
}