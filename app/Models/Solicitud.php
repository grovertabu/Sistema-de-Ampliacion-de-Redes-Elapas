<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function informes()
    {
        return $this->hasMany('App\Models\Informe');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User','cronogramas','user_id','solicitud_id');
    }
}
