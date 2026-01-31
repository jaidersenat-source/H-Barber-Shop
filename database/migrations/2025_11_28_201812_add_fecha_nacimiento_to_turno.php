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
        $table->date('tur_fecha_nacimiento')->nullable()->after('tur_correo');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('turno', function (Blueprint $table) {
        $table->dropColumn('tur_fecha_nacimiento');
    });
    }
};
