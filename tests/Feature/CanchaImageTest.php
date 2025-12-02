<?php

namespace Tests\Feature;

use App\Models\Cancha;
use App\Models\TipoCancha;
use App\Models\Usuario;
use App\Models\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CanchaImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_cancha_image()
    {
        Storage::fake('public');

        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_img',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $tipo = TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        $file = UploadedFile::fake()->image('cancha.jpg');

        $response = $this->actingAs($user)->post(route('canchas.store'), [
            'nombre' => 'Cancha con Foto',
            'tipo_id' => $tipo->id,
            'precio_hora' => 100,
            'disponible' => 1,
            'foto' => $file,
        ]);

        $response->assertRedirect(route('canchas.index'));
        
        $cancha = Cancha::first();
        $this->assertNotNull($cancha->foto);
        Storage::disk('public')->assertExists($cancha->foto);
    }

    public function test_admin_can_update_cancha_image()
    {
        Storage::fake('public');

        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_update_img',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $tipo = TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        $cancha = Cancha::create([
            'nombre' => 'Cancha Original',
            'tipo_id' => $tipo->id,
            'precio_hora' => 100,
            'disponible' => 1
        ]);

        $newFile = UploadedFile::fake()->image('new_cancha.jpg');

        $response = $this->actingAs($user)->put(route('canchas.update', $cancha), [
            'nombre' => 'Cancha Actualizada',
            'tipo_id' => $tipo->id,
            'precio_hora' => 120,
            'disponible' => 1,
            'foto' => $newFile,
        ]);

        $response->assertRedirect(route('canchas.index'));
        
        $cancha->refresh();
        Storage::disk('public')->assertExists($cancha->foto);
    }

    public function test_image_is_deleted_when_cancha_is_deleted()
    {
        Storage::fake('public');

        $role = Roles::firstOrCreate(['nombre' => 'administrador']);
        $user = Usuario::create([
            'nombre_usuario' => 'admin_delete_img',
            'contrasena' => Hash::make('password'),
            'rol_id' => $role->id
        ]);

        $tipo = TipoCancha::firstOrCreate(['nombre' => 'Futbol 5']);
        $file = UploadedFile::fake()->image('delete_me.jpg');
        $path = $file->store('canchas', 'public');

        $cancha = Cancha::create([
            'nombre' => 'Cancha Delete',
            'tipo_id' => $tipo->id,
            'precio_hora' => 100,
            'disponible' => 1,
            'foto' => $path
        ]);

        Storage::disk('public')->assertExists($cancha->foto);

        $response = $this->actingAs($user)->delete(route('canchas.destroy', $cancha));
        
        $response->assertRedirect(route('canchas.index'));
        $this->assertDatabaseMissing('canchas', ['id' => $cancha->id]);
        Storage::disk('public')->assertMissing($cancha->foto);
    }
}
