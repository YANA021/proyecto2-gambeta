<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bloqueo_horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cancha_id')->constrained('canchas')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('motivo');
            $table->foreignId('created_by')->nullable()->constrained('usuarios')->onDelete('set null');
            $table->timestamps();

            $table->index(['cancha_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bloqueo_horarios');
    }
};
