<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_id')->constrained('pagos')->cascadeOnDelete();
            $table->string('url_comprobante');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comprobantes');
    }
};
