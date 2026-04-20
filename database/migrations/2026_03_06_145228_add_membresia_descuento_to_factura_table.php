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
        Schema::table('factura', function (Blueprint $table) {
            // Descuento de membresía aplicado al servicio principal al crear la factura.
            // Necesario para que recalcularTotal() no lo pierda al agregar extras.
            $table->decimal('membresia_descuento', 10, 2)->default(0)->after('fac_abono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factura', function (Blueprint $table) {
            $table->dropColumn('membresia_descuento');
        });
    }
};
