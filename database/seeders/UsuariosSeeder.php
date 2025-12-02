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

        Usuario::updateOrCreate(
            ['nombre_usuario' => 'admin'],
            [
                'contrasena' => 'admin123', // el modelo convierte esto a hash
                'rol_id' => $adminRole->id
            ]
        );
    }
}
