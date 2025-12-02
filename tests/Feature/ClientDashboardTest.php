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

    public function test_client_can_access_dashboard()
    {
        $role = Roles::firstOrCreate(['nombre' => 'cliente']);
        $user = Usuario::create([
            'nombre_usuario' => 'client_test',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $response = $this->actingAs($user)->get(route('cliente.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Hola, client_test');
    }

    public function test_login_redirects_client_to_client_dashboard()
    {
        $role = Roles::firstOrCreate(['nombre' => 'cliente']);
        $user = Usuario::create([
            'nombre_usuario' => 'client_login',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $response = $this->post('/login', [
            'nombre_usuario' => 'client_login',
            'contrasena' => 'password',
        ]);

        $response->assertRedirect(route('cliente.dashboard'));
    }

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

    public function test_registration_redirects_to_client_dashboard()
    {
        $response = $this->post('/register', [
            'nombre_usuario' => 'new_client',
            'contrasena' => 'password123',
            'contrasena_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('cliente.dashboard'));
    }
}
