<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('factura', function (Blueprint $table) {
            // Total real cobrado (con todos los descuentos aplicados)
            $table->decimal('fac_total_con_descuento', 12, 2)->default(0)->after('fac_total');
        });

        // Rellenar filas existentes: el total con descuento es igual al fac_total actual
        // (que ya guardaba el valor con descuento desde el origen)
        DB::statement('UPDATE factura SET fac_total_con_descuento = fac_total');
    }

    public function down(): void
    {
        Schema::table('factura', function (Blueprint $table) {
            $table->dropColumn('fac_total_con_descuento');
        });
    }
};
