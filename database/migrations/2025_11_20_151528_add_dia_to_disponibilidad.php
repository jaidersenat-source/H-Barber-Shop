<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disponibilidad', function (Blueprint $table) {
            // agregar columna 'dia' para soportar disponibilidad semanal
            $table->enum('dia', [
                'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'
            ])->nullable()->after('per_documento');

            // asegurarnos que dis_fecha sea nullable (si ya existe)
            if (Schema::hasColumn('disponibilidad', 'dis_fecha') === true) {
                $table->date('dis_fecha')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('disponibilidad', function (Blueprint $table) {
            if (Schema::hasColumn('disponibilidad', 'dia') === true) {
                $table->dropColumn('dia');
            }
            // no revertimos el cambio de dis_fecha por seguridad
        });
    }
};
