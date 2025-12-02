<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        \ = [
            ['nombre' => 'administrador'],
            ['nombre' => 'empleado'],
            ['nombre' => 'cliente'],
        ];

        foreach (\ as \) {
            Roles::firstOrCreate(\);
        }

        \->command->info('Roles creados exitosamente: administrador, empleado, cliente');
    }
}
