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
       Schema::create('servicios', function (Blueprint $table) {
    $table->id('serv_id');
    $table->string('serv_nombre');
    $table->text('serv_descripcion')->nullable();
    $table->decimal('serv_precio', 10, 2);
    $table->integer('serv_duracion')->comment('Minutos');
    $table->enum('serv_estado', ['activo', 'inactivo'])->default('activo');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio');
    }
};
