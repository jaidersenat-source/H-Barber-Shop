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
        'pro_imagen',
        'pro_estado',
    ];
}
