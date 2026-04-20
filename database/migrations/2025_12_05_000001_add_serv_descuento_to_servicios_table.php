<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->decimal('serv_descuento', 5, 2)->default(0)->after('serv_precio')->comment('Porcentaje de descuento');
        });
    }
    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropColumn('serv_descuento');
        });
    }
};
