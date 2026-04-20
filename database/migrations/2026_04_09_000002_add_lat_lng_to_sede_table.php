<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sede', function (Blueprint $table) {
            $table->decimal('sede_lat', 10, 7)->nullable()->after('sede_direccion');
            $table->decimal('sede_lng', 10, 7)->nullable()->after('sede_lat');
        });
    }

    public function down(): void
    {
        Schema::table('sede', function (Blueprint $table) {
            $table->dropColumn(['sede_lat', 'sede_lng']);
        });
    }
};
