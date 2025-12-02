<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_admin_can_login()
    {
        // obtener o crear rol (la migración siembra 'administrador')
        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        
        // crear usuario
        $user = Usuario::create([
            'nombre_usuario' => 'admin_test',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $response = $this->post('/login', [
            'nombre_usuario' => 'admin_test',
            'contrasena' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_login_fails()
    {
        $response = $this->post('/login', [
            'nombre_usuario' => 'wrong',
            'contrasena' => 'wrong',
        ]);

        $response->assertSessionHasErrors('nombre_usuario');
        $this->assertGuest();
    }

    public function test_admin_routes_protected()
    {
        $response = $this->get(route('usuarios.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_role_middleware_blocks_unauthorized_access()
    {
        // crear rol de empleado y usuario
        $role = Roles::firstOrCreate(['nombre' => 'empleado']);
        $user = Usuario::create([
            'nombre_usuario' => 'emp_test',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $this->actingAs($user);

        // intentar acceder a ruta solo para administradores
        $response = $this->get(route('usuarios.index'));
        $response->assertStatus(403);
    }
}
