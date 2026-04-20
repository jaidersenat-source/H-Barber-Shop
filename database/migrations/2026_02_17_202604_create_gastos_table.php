<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')
                  ->constrained('categorias_gastos')
                  ->restrictOnDelete();
            $table->foreignId('sede_id')
                  ->nullable()
                  ->constrained('sedes')
                  ->nullOnDelete();
            $table->string('descripcion');
            $table->decimal('monto', 10, 2);
            $table->date('fecha');
            $table->string('comprobante')->nullable();
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};