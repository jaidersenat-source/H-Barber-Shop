<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Agrega campo JSON para almacenar los IDs de productos incluidos en un kit.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->json('pro_productos_kit')->nullable()->after('pro_categoria')
                  ->comment('IDs de productos incluidos cuando la categoría es kit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('pro_productos_kit');
        });
    }
};
