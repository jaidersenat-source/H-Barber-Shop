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
        Schema::table('clientes_membresias', function (Blueprint $table) {
            // Contador de usos consumidos por el cliente dentro de esta membresía
            $table->unsignedInteger('usos_usados')->default(0)->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes_membresias', function (Blueprint $table) {
            $table->dropColumn('usos_usados');
        });
    }
};
