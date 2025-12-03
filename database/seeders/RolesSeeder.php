<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'administrador'],
            ['nombre' => 'empleado'],
        ];

        foreach ($roles as $role) {
            Roles::firstOrCreate($role);
        }

        $this->command?->info('Roles creados exitosamente: administrador, empleado');
    }
}
