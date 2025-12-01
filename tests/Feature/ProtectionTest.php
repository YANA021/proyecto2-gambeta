<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_users_cannot_access_admin_dashboard()
    {
        $response = $this->get('/admin');
        $response->assertRedirect(route('login'));
    }

    public function test_unauthenticated_users_cannot_access_client_dashboard()
    {
        $response = $this->get('/cliente');
        $response->assertRedirect(route('login'));
    }

    public function test_unauthenticated_users_cannot_access_protected_resources()
    {
        $routes = [
            '/canchas',
            '/reservas',
            '/pagos',
            '/usuarios',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertRedirect(route('login'));
        }
    }
}
