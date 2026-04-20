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
       Schema::create('productos', function (Blueprint $table) {
    $table->id('pro_id');
    $table->string('pro_nombre');
    $table->text('pro_descripcion')->nullable();
    $table->decimal('pro_precio', 10, 2);
    $table->integer('pro_stock')->default(0);
    $table->string('pro_imagen')->nullable(); // ruta o nombre archivo
    $table->enum('pro_estado', ['activo','inactivo'])->default('activo');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
