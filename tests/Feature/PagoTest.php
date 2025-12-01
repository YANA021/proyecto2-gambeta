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

class PagoTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_pago()
    {
        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_pago',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $cliente = Cliente::create(['nombre' => 'Cliente Pago', 'telefono' => '123']);
        $tipo = TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        $cancha = Cancha::create(['nombre' => 'Cancha Pago', 'tipo_id' => $tipo->id, 'precio_hora' => 100, 'disponible' => 1]);
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

        $response = $this->actingAs($user)->post(route('pagos.store'), [
            'reserva_id' => $reserva->id,
            'cliente_id' => $cliente->id,
            'monto' => 100,
            'fecha_pago' => now()->format('Y-m-d'),
            'metodo' => 'efectivo',
            'estado_pago' => 'completado'
        ]);

        $response->assertRedirect(route('pagos.index'));
        $this->assertDatabaseHas('pagos', ['monto' => 100, 'estado_pago' => 'completado']);
    }

    public function test_pdf_generation()
    {
        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_pdf',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $cliente = Cliente::create(['nombre' => 'Cliente PDF', 'telefono' => '123']);
        $tipo = TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        $cancha = Cancha::create(['nombre' => 'Cancha PDF', 'tipo_id' => $tipo->id, 'precio_hora' => 100, 'disponible' => 1]);
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

        $pago = Pago::create([
            'reserva_id' => $reserva->id,
            'cliente_id' => $cliente->id,
            'monto' => 100,
            'fecha_pago' => now()->format('Y-m-d'),
            'metodo' => 'efectivo',
            'estado_pago' => 'completado'
        ]);

        $response = $this->actingAs($user)->get(route('comprobantes.show', $pago->id));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
