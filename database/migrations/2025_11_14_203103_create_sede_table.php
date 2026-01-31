<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sede', function (Blueprint $table) {
            $table->id('sede_id');
            $table->string('sede_nombre');
            $table->string('sede_direccion');
            $table->string('sede_logo', 500)->nullable();
            $table->string('sede_slogan')->nullable();
            $table->text('sede_descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sede');
    }
};
