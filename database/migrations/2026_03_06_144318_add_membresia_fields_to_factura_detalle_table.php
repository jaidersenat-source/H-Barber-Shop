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
        Schema::table('factura_detalle', function (Blueprint $table) {
            // Precio original antes de aplicar el beneficio de membresía
            $table->decimal('precio_original', 10, 2)->nullable()->after('facdet_subtotal');
            // Monto descontado gracias a la membresía (0 si no aplica)
            $table->decimal('descuento_membresia', 10, 2)->default(0)->after('precio_original');
            // Tipo de beneficio aplicado: 'gratis', 'porcentaje' o null
            $table->string('tipo_descuento', 50)->nullable()->after('descuento_membresia');
            // FK a clientes_membresias para trazabilidad
            $table->unsignedBigInteger('cliente_membresia_id')->nullable()->after('tipo_descuento');

            $table->foreign('cliente_membresia_id')
                  ->references('id')
                  ->on('clientes_membresias')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factura_detalle', function (Blueprint $table) {
            $table->dropForeign(['cliente_membresia_id']);
            $table->dropColumn([
                'precio_original',
                'descuento_membresia',
                'tipo_descuento',
                'cliente_membresia_id',
            ]);
        });
    }
};
