<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_is_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        // asegurar que el rol exista (o dejar que el controlador lo cree)
        
        $response = $this->post('/register', [
            'nombre_usuario' => 'new_user',
            'contrasena' => 'password123',
            'contrasena_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        
        $this->assertDatabaseHas('usuarios', [
            'nombre_usuario' => 'new_user',
        ]);

        $user = Usuario::where('nombre_usuario', 'new_user')->first();
        $this->assertAuthenticatedAs($user);
        $this->assertEquals('cliente', strtolower($user->rol->nombre));
    }

    public function test_registration_fails_with_password_mismatch()
    {
        $response = $this->post('/register', [
            'nombre_usuario' => 'fail_user',
            'contrasena' => 'password123',
            'contrasena_confirmation' => 'wrong',
        ]);

        $response->assertSessionHasErrors('contrasena');
        $this->assertGuest();
    }
}
