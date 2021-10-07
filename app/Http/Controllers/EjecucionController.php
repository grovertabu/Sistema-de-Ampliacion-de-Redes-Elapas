<?php

namespace App\Http\Controllers;

use App\Models\Ejecucion;
use Illuminate\Http\Request;
use App\Models\Informe;

class EjecucionController extends Controller
{
    public function store(Request $request){
        $informe = Informe::find($request->informe_id);
        $informe->estado_in = 'programado';
        $informe->save();

        $ejecucion = new Ejecucion();
        $ejecucion->fecha_progrmada = $request->fecha_programada;
        $ejecucion->informe_id = $request->informe_id;
        $ejecucion->user_id = $request->user_id;
        $ejecucion->save();

        return redirect()->route('informes.concluido');
    }
}
