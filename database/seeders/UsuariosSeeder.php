<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Roles::firstOrCreate(['nombre' => 'administrador']);
        $empleadoRole = Roles::firstOrCreate(['nombre' => 'empleado']);

        Usuario::updateOrCreate(
            ['nombre_usuario' => 'admin'],
            [
                'contrasena' => 'admin123', // el modelo convierte esto a hash
                'rol_id' => $adminRole->id
            ]
        );

        Usuario::updateOrCreate(
            ['nombre_usuario' => 'empleado'],
            [
                'contrasena' => 'empleado123', // hash automático por el modelo
                'rol_id' => $empleadoRole->id
            ]
        );
    }
}
