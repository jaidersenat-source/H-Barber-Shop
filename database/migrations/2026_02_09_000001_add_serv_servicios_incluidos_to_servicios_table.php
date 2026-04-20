<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->json('serv_servicios_incluidos')->nullable()->after('serv_estado')
                ->comment('IDs de servicios incluidos cuando la categoría es combo');
        });
    }

    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropColumn('serv_servicios_incluidos');
        });
    }
};
