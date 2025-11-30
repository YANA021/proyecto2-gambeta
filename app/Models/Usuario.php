<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_usuario',
        'contrasena',
        'empleado_id',
        'rol_id',
    ];

    protected $hidden = [
        'contrasena',
    ];

    protected static ?int $defaultRoleId = null;

    protected static function booted(): void
    {
        static::creating(function (self $usuario): void {
            if (!$usuario->rol_id) {
                $usuario->rol_id = static::$defaultRoleId ??= Roles::query()
                    ->where('nombre', Roles::DEFAULT_ROLE)
                    ->value('id');
            }
        });
    }

    /**
     * Use Laravel's password hashing for the custom column name.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->contrasena;
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Roles::class, 'rol_id');
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }
}
