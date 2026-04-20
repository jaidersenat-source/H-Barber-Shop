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
        Schema::table('turno', function (Blueprint $table) {
            $table->enum('tur_estado_pago', ['sin_anticipo', 'pendiente_pago', 'confirmado'])->default('sin_anticipo')->after('tur_estado');
            $table->decimal('tur_anticipo', 10, 2)->nullable()->after('tur_estado_pago');
            $table->string('tur_referencia_pago', 255)->nullable()->after('tur_anticipo');
            $table->timestamp('tur_fecha_pago')->nullable()->after('tur_referencia_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turno', function (Blueprint $table) {
            $table->dropColumn(['tur_estado_pago', 'tur_anticipo', 'tur_referencia_pago', 'tur_fecha_pago']);
        });
    }
};
