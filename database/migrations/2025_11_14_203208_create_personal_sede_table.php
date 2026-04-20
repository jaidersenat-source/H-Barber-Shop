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
        Schema::create('personal_sede', function (Blueprint $table) {
            $table->id('persede_id');

            $table->unsignedBigInteger('sede_id');
            $table->string('per_documento');
            $table->dateTime('persede_fecha_registro');
            $table->enum('persede_estado', ['inactivo', 'activo']);

            $table->timestamps();

            // Relaciones
            $table->foreign('sede_id')->references('sede_id')->on('sede')->onDelete('cascade');
            $table->foreign('per_documento')->references('per_documento')->on('persona')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_sede');
    }
};
