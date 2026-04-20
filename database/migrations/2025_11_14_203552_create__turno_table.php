<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('turno', function (Blueprint $table) {
            $table->id('tur_id');
            $table->unsignedBigInteger('dis_id'); // FK a disponibilidad (semana)
            $table->date('tur_fecha');            // fecha concreta
            $table->time('tur_hora');             // hora inicio del turno
            $table->integer('tur_duracion')->nullable(); // minutos (opcional)
            $table->string('tur_nombre');
            $table->string('tur_celular');
            $table->string('tur_correo')->nullable();
            $table->enum('tur_estado', ['Pendiente','Cancelado','Realizado'])->default('Pendiente');
            $table->timestamps();

            $table->foreign('dis_id')->references('dis_id')->on('disponibilidad')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turno');
    }
};