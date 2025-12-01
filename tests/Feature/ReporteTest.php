<?php

namespace Tests\Feature;

use App\Models\Pago;
use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Cancha;
use App\Models\TipoCancha;
use App\Models\Usuario;
use App\Models\Roles;
use App\Models\EstadoReserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReporteTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_reports()
    {
        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_reporte',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        // Crear datos de prueba
        $cliente = Cliente::create(['nombre' => 'Cliente Reporte', 'telefono' => '123']);
        $tipo = TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        $cancha = Cancha::create(['nombre' => 'Cancha Reporte', 'tipo_id' => $tipo->id, 'precio_hora' => 100, 'disponible' => 1]);
        $estado = EstadoReserva::create(['nombre' => 'Pendiente']);
        
        $reserva = Reserva::create([
            'cancha_id' => $cancha->id,
            'cliente_id' => $cliente->id,
            'fecha' => now()->format('Y-m-d'),
            'hora_inicio' => '10:00',
            'duracion_horas' => 1,
            'precio_total' => 100,
            'estado_id' => $estado->id
        ]);

        Pago::create([
            'reserva_id' => $reserva->id,
            'cliente_id' => $cliente->id,
            'monto' => 100,
            'fecha_pago' => now()->format('Y-m-d'),
            'metodo' => 'efectivo',
            'estado_pago' => 'completado'
        ]);

        $response = $this->actingAs($user)->get(route('reportes.index'));

        $response->assertStatus(200);
        $response->assertViewHas('ingresosHoy', 100);
        $response->assertViewHas('reservasMes');
        $response->assertViewHas('chartLabels');
    }
}
