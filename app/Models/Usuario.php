<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
     * usar el hash de contraseñas de laravel para el nombre de columna personalizado.
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

    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 'usuario_id');
    }

    public function hasRole(string $role): bool
    {
        return strtolower($this->rol->nombre) === strtolower($role);
    }
}
