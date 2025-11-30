<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estados_reserva', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        DB::table('estados_reserva')->insert([
            ['nombre' => 'pendiente', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'confirmada', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'en_proceso', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'finalizada', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'cancelada', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('estados_reserva');
    }
};
