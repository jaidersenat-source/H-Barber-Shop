<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaGasto extends Model
{
    protected $table = 'categorias_gastos';

    protected $fillable = ['nombre', 'descripcion', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function gastos(): HasMany
    {
        return $this->hasMany(Gasto::class, 'categoria_id');
    }

    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }
}