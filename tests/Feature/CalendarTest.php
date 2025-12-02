<?php

namespace Tests\Feature;

use App\Livewire\CalendarioReservas;
use App\Models\Cancha;
use App\Models\TipoCancha;
use App\Models\Usuario;
use App\Models\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_calendar_component_renders()
    {
        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_calendar',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $tipo = TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        Cancha::create([
            'nombre' => 'Cancha Test',
            'tipo_id' => $tipo->id,
            'precio_hora' => 100,
            'disponible' => 1
        ]);

        $this->actingAs($user)
            ->get(route('reservas.calendar'))
            ->assertStatus(200)
            ->assertSeeLivewire(CalendarioReservas::class);
    }

    public function test_calendar_shows_available_slots()
    {
        $tipo = TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        $cancha = Cancha::create([
            'nombre' => 'Cancha Slots',
            'tipo_id' => $tipo->id,
            'precio_hora' => 100,
            'disponible' => 1
        ]);

        Livewire::test(CalendarioReservas::class)
            ->set('cancha_id', $cancha->id)
            ->set('fecha', now()->format('Y-m-d'))
            ->assertSee('08:00 AM')
            ->assertSee('Disponible');
    }
}
