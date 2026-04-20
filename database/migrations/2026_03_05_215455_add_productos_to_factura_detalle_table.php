<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('factura_detalle', function (Blueprint $table) {
            // Hacer serv_id nullable para soportar detalles de solo producto
            $table->unsignedBigInteger('serv_id')->nullable()->change();

            // Nuevos campos para productos
            $table->unsignedBigInteger('pro_id')->nullable()->after('serv_id');
            $table->string('facdet_descripcion')->nullable()->after('pro_id');
            $table->integer('facdet_cantidad')->default(1)->after('facdet_descripcion');
            $table->decimal('facdet_precio_unitario', 12, 2)->default(0)->after('facdet_cantidad');
            $table->decimal('facdet_subtotal', 12, 2)->default(0)->after('facdet_precio_unitario');

            // Foreign key
            $table->foreign('pro_id')
                  ->references('pro_id')
                  ->on('productos')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('factura_detalle', function (Blueprint $table) {
            $table->dropForeign(['pro_id']);
            $table->dropColumn(['pro_id', 'facdet_descripcion', 'facdet_cantidad', 'facdet_precio_unitario', 'facdet_subtotal']);
        });
    }
};