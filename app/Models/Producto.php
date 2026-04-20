<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'pro_id';

    protected $fillable = [
        'pro_nombre',
        'pro_descripcion',
        'pro_precio',
        'pro_descuento',
        'pro_stock',
        'pro_categoria',
        'pro_productos_kit',
        'pro_imagen',
        'pro_estado',
    ];

    protected $casts = [
        'pro_productos_kit' => 'array',
    ];

    /**
     * Verifica si el producto es un kit.
     */
    public function esKit(): bool
    {
        return $this->pro_categoria === 'kit';
    }

    /**
     * Obtiene los productos incluidos en el kit.
     */
    public function productosDelKit()
    {
        if (!$this->esKit() || empty($this->pro_productos_kit)) {
            return collect();
        }
        return self::whereIn('pro_id', $this->pro_productos_kit)
            ->where('pro_categoria', '!=', 'kit')
            ->get();
    }

    /**
     * Productos disponibles para ser incluidos en kits (excluyendo otros kits).
     */
    public static function disponiblesParaKit()
    {
        return self::where('pro_categoria', '!=', 'kit')
            ->where('pro_estado', 'activo')
            ->orderBy('pro_nombre')
            ->get();
    }

       public function facturaDetalles()
    {
        return $this->hasMany(FacturaDetalle::class, 'pro_id', 'pro_id');
    }


}
