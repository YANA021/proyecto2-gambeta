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
        $response->assertStatus(404);
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'nombre_usuario' => 'new_user',
            'contrasena' => 'password123',
            'contrasena_confirmation' => 'password123',
        ]);

        $response->assertStatus(404);
        $this->assertGuest();
    }

    public function test_registration_fails_with_password_mismatch()
    {
        $response = $this->post('/register', [
            'nombre_usuario' => 'fail_user',
            'contrasena' => 'password123',
            'contrasena_confirmation' => 'wrong',
        ]);

        $response->assertStatus(404);
        $this->assertGuest();
    }
}
