<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factura', function (Blueprint $table) {
            $table->id('fac_id');
            $table->dateTime('fac_fecha')->default(now());

            $table->unsignedBigInteger('sede_id');
            $table->unsignedBigInteger('tur_id');

            $table->decimal('fac_total', 10, 2);
            $table->decimal('fac_abono', 10, 2)->default(0);

            $table->timestamps();

            $table->foreign('sede_id')->references('sede_id')->on('sede')
                ->onDelete('cascade');

            $table->foreign('tur_id')->references('tur_id')->on('turno')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factura');
    }
};
