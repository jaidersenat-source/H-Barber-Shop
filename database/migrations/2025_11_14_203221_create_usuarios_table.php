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
        Schema::create('usuarios', function (Blueprint $table) {
    $table->id('usuario_id');
    $table->string('per_documento')->unique();
    $table->string('usuario')->unique();
    $table->string('password');
    $table->enum('rol', ['admin', 'barbero']);
    $table->dateTime('ultimo_acceso')->nullable();
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
        Schema::dropIfExists('usuarios');
    }
};
