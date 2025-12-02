<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('GAMBETA');
    }

    public function test_has_role_method()
    {
        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_role_test',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $this->assertTrue($user->hasRole('Administrador'));
        $this->assertTrue($user->hasRole('administrador'));
        $this->assertFalse($user->hasRole('cliente'));
    }

    public function test_landing_page_shows_dashboard_link_for_admin()
    {
        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_landing',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSee('Ir al Panel');
        // esto aquí debería enlazar al panel de administración
        $response->assertSee(route('admin.dashboard'));
    }

    public function test_landing_page_shows_dashboard_link_for_client()
    {
        $role = Roles::firstOrCreate(['nombre' => 'cliente']);
        $user = Usuario::create([
            'nombre_usuario' => 'client_landing',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSee('Ir al Panel');
        // esto aquí debería enlazar al panel de cliente
        $response->assertSee(route('cliente.dashboard'));
    }
}
