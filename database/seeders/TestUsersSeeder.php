<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Roles;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // roles
        $adminRole = Roles::firstOrCreate(['nombre' => 'Administrador']);
        $empleadoRole = Roles::firstOrCreate(['nombre' => 'Empleado']);
        $clienteRole = Roles::firstOrCreate(['nombre' => 'Cliente']);

        // usuarios
        Usuario::firstOrCreate(
            ['nombre_usuario' => 'admin'],
            ['contrasena' => Hash::make('password'), 'rol_id' => $adminRole->id]
        );

        Usuario::firstOrCreate(
            ['nombre_usuario' => 'empleado'],
            ['contrasena' => Hash::make('password'), 'rol_id' => $empleadoRole->id]
        );

        Usuario::firstOrCreate(
            ['nombre_usuario' => 'cliente'],
            ['contrasena' => Hash::make('password'), 'rol_id' => $clienteRole->id]
        );

        // clientes (datos para reservas)
        Cliente::firstOrCreate(
            ['nombre' => 'Juan Pérez'],
            ['telefono' => '555-0001']
        );

        Cliente::firstOrCreate(
            ['nombre' => 'María López'],
            ['telefono' => '555-0002']
        );
        
        Cliente::firstOrCreate(
            ['nombre' => 'Carlos Ruiz'],
            ['telefono' => '555-0003']
        );
    }
}
