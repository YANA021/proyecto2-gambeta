<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EmpleadoDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_access_dashboard()
    {
        $roleEmpleado = Roles::firstOrCreate(['nombre' => 'Empleado']);
        $employee = Usuario::create([
            'nombre_usuario' => 'empleado_test',
            'contrasena' => Hash::make('password'),
            'rol_id' => $roleEmpleado->id
        ]);

        $response = $this->actingAs($employee)->get(route('empleado.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('stats');
        $response->assertViewHas('reservasHoy');
        $response->assertSee('Panel de Recepción');
    }

    public function test_employee_redirected_to_employee_dashboard_on_login()
    {
        $roleEmpleado = Roles::firstOrCreate(['nombre' => 'Empleado']);
        $employee = Usuario::create([
            'nombre_usuario' => 'empleado_login',
            'contrasena' => Hash::make('password'),
            'rol_id' => $roleEmpleado->id
        ]);

        $response = $this->post(route('login'), [
            'nombre_usuario' => 'empleado_login',
            'contrasena' => 'password'
        ]);

        $response->assertRedirect(route('empleado.dashboard'));
    }

    public function test_admin_still_redirected_to_admin_dashboard()
    {
        $roleAdmin = Roles::firstOrCreate(['nombre' => 'Administrador']);
        $admin = Usuario::create([
            'nombre_usuario' => 'admin_test',
            'contrasena' => Hash::make('password'),
            'rol_id' => $roleAdmin->id
        ]);

        $response = $this->post(route('login'), [
            'nombre_usuario' => 'admin_test',
            'contrasena' => 'password'
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }
}
