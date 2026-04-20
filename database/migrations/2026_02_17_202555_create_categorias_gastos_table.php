<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias_gastos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Categorías por defecto
        DB::table('categorias_gastos')->insert([
            ['nombre' => 'Arriendo',           'descripcion' => 'Pago de arriendo del local',       'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Servicios públicos',  'descripcion' => 'Agua, luz, gas, internet',          'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Insumos',             'descripcion' => 'Productos y materiales de trabajo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Nómina',              'descripcion' => 'Pago de salarios al personal',      'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Otros',               'descripcion' => 'Gastos varios no categorizados',    'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_gastos');
    }
};