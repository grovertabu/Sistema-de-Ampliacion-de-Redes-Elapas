<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aporte_m_vecino extends Model
{
    use HasFactory;

    public function informe()
    {
        return $this->belongsTO('App\Models\Informe');
    }
}
