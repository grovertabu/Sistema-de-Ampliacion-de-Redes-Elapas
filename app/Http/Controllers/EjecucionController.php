<?php

namespace App\Http\Controllers;

use App\Models\Ejecucion;
use Illuminate\Http\Request;
use App\Models\Informe;

class EjecucionController extends Controller
{
    public function store(Request $request)
    {
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

    public function ejecutada($id_ejecucion,  Request $request)
    {
        $informe = Informe::find($request->id_informe);
        $informe->estado_in = "ejecutado";
        $informe->save();

        $ejecucion = Ejecucion::find($id_ejecucion);
        $ejecucion->fecha_ejecutada = $request->fecha_ejecutada;
        $ejecucion->save();

        return redirect()->route('informes.concluido');
    }
}
