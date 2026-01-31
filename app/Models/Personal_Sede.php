<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Persona;

class Personal_Sede extends Model {
    protected $table = 'personal_sede';
    protected $primaryKey = 'persede_id';

    protected $fillable = [
        'sede_id','per_documento','persede_fecha_registro','persede_estado'
    ];

    public function persona(){
        return $this->belongsTo(Persona::class, 'per_documento', 'per_documento');
    }

    public function sede(){
        return $this->belongsTo('App\Models\Sede', 'sede_id', 'sede_id');
    }
}