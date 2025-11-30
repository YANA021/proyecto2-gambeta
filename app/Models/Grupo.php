<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'grupo_id');
    }
}
