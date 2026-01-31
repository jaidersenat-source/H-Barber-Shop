<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disponibilidad', function (Blueprint $table) {
        $table->id('dis_id');
        $table->string('per_documento'); // FK persona

        // Nuevo campo para semana
        $table->enum('dia', [
            'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'
        ])->nullable();

        // Mantienes fecha opcional
        $table->date('dis_fecha')->nullable();

        $table->time('dis_hora_inicio');
        $table->time('dis_hora_fin');

        $table->enum('dis_estado', ['inactivo','disponible','ocupado'])
              ->default('disponible');

        $table->timestamps();

        $table->foreign('per_documento')
            ->references('per_documento')
            ->on('persona')
            ->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disponibilidad'); // ← CORREGIDO
    }
};
