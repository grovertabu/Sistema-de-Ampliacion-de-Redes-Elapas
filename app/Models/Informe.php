<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function solicitud()
    {
        return $this->belongsTO('App\Models\Solicitud');
    }
    public function materials()
    {
        return $this->belongsToMany('App\Models\Material','informe_materials','informe_id','material_id');
    }
    public function aporte_m_vecinos()
    {
        return $this->hasMany('App\Models\Aporte_m_vecino');
    }
}
