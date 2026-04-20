<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla turno — columnas consultadas frecuentemente sin índice
        Schema::table('turno', function (Blueprint $table) {
            $table->index('tur_fecha', 'idx_turno_fecha');
            $table->index('tur_cedula', 'idx_turno_cedula');
            $table->index('tur_estado', 'idx_turno_estado');
            $table->index('tur_estado_pago', 'idx_turno_estado_pago');
            $table->index('per_documento', 'idx_turno_per_documento');
        });

        // Tabla disponibilidad
        Schema::table('disponibilidad', function (Blueprint $table) {
            $table->index('dis_fecha', 'idx_disponibilidad_fecha');
            $table->index('dis_estado', 'idx_disponibilidad_estado');
            $table->index(['per_documento', 'dia'], 'idx_disponibilidad_persona_dia');
        });

        // Tabla fidelizacion
        Schema::table('fidelizacion', function (Blueprint $table) {
            $table->index('tur_cedula', 'idx_fidelizacion_cedula');
        });

        // Tabla factura
        Schema::table('factura', function (Blueprint $table) {
            $table->index('fac_fecha', 'idx_factura_fecha');
        });

        // Tabla clientes_membresias
        Schema::table('clientes_membresias', function (Blueprint $table) {
            $table->index('cliente_cedula', 'idx_clientes_membresias_cedula');
            $table->index('estado', 'idx_clientes_membresias_estado');
        });

        // Tabla usuarios
        Schema::table('usuarios', function (Blueprint $table) {
            $table->index('rol', 'idx_usuarios_rol');
            $table->index('estado', 'idx_usuarios_estado');
        });
    }

    public function down(): void
    {
        Schema::table('turno', function (Blueprint $table) {
            $table->dropIndex('idx_turno_fecha');
            $table->dropIndex('idx_turno_cedula');
            $table->dropIndex('idx_turno_estado');
            $table->dropIndex('idx_turno_estado_pago');
            $table->dropIndex('idx_turno_per_documento');
        });

        Schema::table('disponibilidad', function (Blueprint $table) {
            $table->dropIndex('idx_disponibilidad_fecha');
            $table->dropIndex('idx_disponibilidad_estado');
            $table->dropIndex('idx_disponibilidad_persona_dia');
        });

        Schema::table('fidelizacion', function (Blueprint $table) {
            $table->dropIndex('idx_fidelizacion_cedula');
        });

        Schema::table('factura', function (Blueprint $table) {
            $table->dropIndex('idx_factura_fecha');
        });

        Schema::table('clientes_membresias', function (Blueprint $table) {
            $table->dropIndex('idx_clientes_membresias_cedula');
            $table->dropIndex('idx_clientes_membresias_estado');
        });

        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropIndex('idx_usuarios_rol');
            $table->dropIndex('idx_usuarios_estado');
        });
    }
};
