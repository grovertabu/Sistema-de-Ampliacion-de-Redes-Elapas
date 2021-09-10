<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public function informes()
    {
        return $this->belongsToMany('App\Models\Informe','informe_materials','informe_id','material_id');
    }
}
