<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class ClientDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_redirects_admin_to_admin_dashboard()
    {
        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_login',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $response = $this->post('/login', [
            'nombre_usuario' => 'admin_login',
            'contrasena' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_login_redirects_empleado_to_empleado_dashboard()
    {
        $role = Roles::firstOrCreate(['nombre' => 'empleado']);
        $user = Usuario::create([
            'nombre_usuario' => 'empleado_login',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $response = $this->post('/login', [
            'nombre_usuario' => 'empleado_login',
            'contrasena' => 'password',
        ]);

        $response->assertRedirect(route('empleado.dashboard'));
    }
}
