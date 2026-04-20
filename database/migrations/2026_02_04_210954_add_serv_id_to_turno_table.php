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
            $table->unsignedBigInteger('serv_id')->nullable()->after('dis_id');
            $table->foreign('serv_id')->references('serv_id')->on('servicios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turno', function (Blueprint $table) {
            $table->dropForeign(['serv_id']);
            $table->dropColumn('serv_id');
        });
    }
};
