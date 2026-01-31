<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('factura_detalle', function (Blueprint $table) {
            $table->string('serv_nombre')->nullable()->after('serv_id');
        });
    }

    public function down()
    {
        Schema::table('factura_detalle', function (Blueprint $table) {
            $table->dropColumn('serv_nombre');
        });
    }
};
