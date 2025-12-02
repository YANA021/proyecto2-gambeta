<?php

namespace Tests\Feature;

use App\Livewire\CrearReserva;
use App\Models\Cancha;
use App\Models\Cliente;
use App\Models\EstadoReserva;
use App\Models\TipoCancha;
use App\Models\Usuario;
use App\Models\Roles;
use App\Models\Reserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ReservaFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_reserva_price_calculation()
    {
        $tipo = TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        $cancha = Cancha::create([
            'nombre' => 'Cancha Precio',
            'tipo_id' => $tipo->id,
            'precio_hora' => 100,
            'disponible' => 1
        ]);

        Livewire::test(CrearReserva::class)
            ->set('cancha_id', $cancha->id)
            ->set('duracion_horas', 2)
            ->assertSet('precio_total', 200);
    }

    public function test_reserva_creation()
    {
        $tipo = TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        $cancha = Cancha::create([
            'nombre' => 'Cancha Test',
            'tipo_id' => $tipo->id,
            'precio_hora' => 100,
            'disponible' => 1
        ]);

        $cliente = Cliente::create(['nombre' => 'Test Client', 'telefono' => '123']);
        EstadoReserva::create(['nombre' => 'Pendiente']);

        Livewire::test(CrearReserva::class)
            ->set('cancha_id', $cancha->id)
            ->set('cliente_id', $cliente->id)
            ->set('fecha', now()->addDay()->format('Y-m-d'))
            ->set('hora_inicio', '10:00')
            ->set('duracion_horas', 1)
            ->call('guardarReserva')
            ->assertRedirect(route('reservas.index'));

        $this->assertDatabaseHas('reservas', [
            'cancha_id' => $cancha->id,
            'cliente_id' => $cliente->id,
        ]);
    }

    public function test_quick_client_creation()
    {
        Livewire::test(CrearReserva::class)
            ->set('nuevoClienteNombre', 'Nuevo Cliente Rapido')
            ->set('nuevoClienteTelefono', '999888777')
            ->call('guardarClienteRapido')
            ->assertSet('showModalCliente', false);

        $this->assertDatabaseHas('clientes', ['nombre' => 'Nuevo Cliente Rapido']);
    }
}
