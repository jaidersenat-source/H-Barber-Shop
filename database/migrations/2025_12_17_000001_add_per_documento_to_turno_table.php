<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('turno', function (Blueprint $table) {
            $table->string('per_documento')->nullable()->after('dis_id'); // identificador del barbero
        });
    }

    public function down()
    {
        Schema::table('turno', function (Blueprint $table) {
            $table->dropColumn('per_documento');
        });
    }
};
