<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Persona; // ← IMPORTANTE

class Disponibilidad extends Model
{
    protected $table = 'disponibilidad';
    protected $primaryKey = 'dis_id';

    protected $fillable = [
        'per_documento',
        'dia',
        'dis_fecha',
        'dis_hora_inicio',
        'dis_hora_fin',
        'dis_estado',
    ];

    public function persona()
    {
        // per_documento de disponibilidad pertenece al per_documento de persona
        return $this->belongsTo(Persona::class, 'per_documento', 'per_documento');
    }
}
