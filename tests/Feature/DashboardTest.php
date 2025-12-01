<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Roles;
use App\Models\Cancha;
use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\Pago;
use App\Models\TipoCancha;
use App\Models\EstadoReserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_loads_with_data()
    {
        // Setup Admin User
        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_dash',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        // Seed some data
        TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        $cancha = Cancha::create(['nombre' => 'Cancha 1', 'tipo_id' => 1, 'precio_hora' => 100]);
        $cliente = Cliente::create(['nombre' => 'Cliente 1', 'telefono' => '1234567890']);
        $estado = EstadoReserva::firstOrCreate(['nombre' => 'pendiente']);
        
        $reserva = Reserva::create([
            'cancha_id' => $cancha->id,
            'cliente_id' => $cliente->id,
            'fecha' => now(),
            'hora_inicio' => '10:00',
            'duracion_horas' => 1,
            'precio_total' => 100,
            'estado_id' => $estado->id
        ]);

        Pago::create([
            'reserva_id' => $reserva->id,
            'cliente_id' => $cliente->id,
            'monto' => 50,
            'fecha_pago' => now(),
            'metodo' => 'Efectivo',
            'estado_pago' => 'pendiente'
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas(['stats', 'recentReservas', 'recentPagos', 'tipos']);
        $response->assertSee('Gambeta Operations');
        $response->assertSee('Cancha 1');
        $response->assertSee('Cliente 1');
    }
}
