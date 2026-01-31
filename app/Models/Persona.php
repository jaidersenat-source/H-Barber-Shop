<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model {

    protected $table = 'persona';

    protected $primaryKey = 'per_documento';
    public $incrementing = false;

    protected $fillable = [
        'per_documento','per_nombre','per_apellido','per_correo','per_telefono'
    ];

    public function sede(){
        return $this->hasMany(Personal_Sede::class, 'per_documento', 'per_documento');
    }

    // Relación a Usuario (si existe)
    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'per_documento', 'per_documento');
    }

    // Relación a Disponibilidad
    public function disponibilidades()
    {
        return $this->hasMany(\App\Models\Disponibilidad::class, 'per_documento', 'per_documento');
    }
}
