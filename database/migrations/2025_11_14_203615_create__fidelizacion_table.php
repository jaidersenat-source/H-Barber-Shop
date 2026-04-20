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
        Schema::create('fidelizacion', function (Blueprint $table) {
            $table->id('fid_id');

            $table->unsignedBigInteger('tur_id'); // FK Turno
               $table->string('tur_celular', 20); // Celular del cliente
               $table->string('tur_nombre', 100); // Nombre del cliente
            $table->integer('visitas_acumuladas')->default(0);
            $table->integer('cortes_gratis')->default(0);

            $table->dateTime('fecha_actualizacion')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('tur_id')
                  ->references('tur_id')
                  ->on('turno')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fidelizacion');
    }
};
