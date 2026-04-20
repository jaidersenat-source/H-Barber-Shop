<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sede', function (Blueprint $table) {
            $table->string('sede_telefono', 30)->nullable()->after('sede_direccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sede', function (Blueprint $table) {
            $table->dropColumn('sede_telefono');
        });
    }
};
