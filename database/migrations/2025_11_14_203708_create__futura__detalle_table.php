<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factura_detalle', function (Blueprint $table) {
    $table->id('facdet_id');
    $table->unsignedBigInteger('fac_id');
    $table->unsignedBigInteger('serv_id');
    $table->decimal('serv_precio', 10, 2);
    $table->timestamps();

    $table->foreign('fac_id')->references('fac_id')->on('factura')->onDelete('cascade');
    $table->foreign('serv_id')->references('serv_id')->on('servicios')->onDelete('cascade');
        });
    }

   public function down(): void
    {
        Schema::dropIfExists('factura_detalle');
    }
};
