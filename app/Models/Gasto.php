<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use App\Models\Usuario;

class Gasto extends Model
{
    protected $fillable = [
        'categoria_id',
        'sede_id',
        'descripcion',
        'monto',
        'fecha',
        'comprobante',
        'created_by',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaGasto::class, 'categoria_id');
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }

    public function getComprobanteUrlAttribute(): ?string
    {
        return $this->comprobante ? Storage::url($this->comprobante) : null;
    }
}