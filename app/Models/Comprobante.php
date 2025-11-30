<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;

    protected $fillable = [
        'pago_id',
        'url_comprobante',
    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
}
