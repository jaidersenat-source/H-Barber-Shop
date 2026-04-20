<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membresias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('duracion_meses');
            $table->json('beneficios')->nullable();
            $table->boolean('activo')->default(true);
            $table->string('imagen', 255)->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('clientes_membresias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cliente_cedula', 20);
            $table->unsignedBigInteger('membresia_id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['activa', 'vencida', 'cancelada'])->default('activa');
            $table->timestamps();

            $table->foreign('membresia_id')->references('id')->on('membresias')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes_membresias');
        Schema::dropIfExists('membresias');
    }
};