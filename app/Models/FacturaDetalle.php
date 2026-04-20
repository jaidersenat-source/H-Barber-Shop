<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaDetalle extends Model
{
    protected $table = 'factura_detalle';
    protected $primaryKey = 'facdet_id';
    public $timestamps = true;

    protected $fillable = [
        'fac_id',
        'serv_id',
        'serv_precio',
        'serv_nombre',
        'pro_id',
        'facdet_descripcion',
        'facdet_cantidad',
        'facdet_precio_unitario',
        'facdet_subtotal',
        'precio_original',
        'descuento_membresia',
        'tipo_descuento',
        'cliente_membresia_id',
    ];

    // Relación con Factura
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'fac_id', 'fac_id');
    }

    // Relación con Servicio
    public function servicios()
    {
        return $this->belongsTo(Servicio::class, 'serv_id', 'serv_id');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'pro_id', 'pro_id');
    }

    /**
     * Determina si este detalle es un producto.
     */
    public function esProducto(): bool
    {
        return !is_null($this->pro_id);
    }

    /**
     * Determina si este detalle es un servicio.
     */
    public function esServicio(): bool
    {
        return !is_null($this->serv_id);
    }
}