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
        Schema::table('usuarios', function (Blueprint $table) {
            // Registro de aceptación de Términos de Uso Interno del CRM (Sección V)
            // Ley 527 de 1999 (firma digital), Ley 1581 de 2012
            $table->timestamp('crm_terms_accepted_at')->nullable()->after('estado');
            $table->string('crm_terms_accepted_ip', 45)->nullable()->after('crm_terms_accepted_at');
            $table->string('crm_terms_version', 10)->nullable()->after('crm_terms_accepted_ip');
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['crm_terms_accepted_at', 'crm_terms_accepted_ip', 'crm_terms_version']);
        });
    }
};
