<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->string('pro_categoria', 50)->nullable()->after('pro_stock');
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('pro_categoria');
        });
    }
};
