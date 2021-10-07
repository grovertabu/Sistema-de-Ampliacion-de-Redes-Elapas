<?php

namespace App\Http\Controllers;

use App\Models\Ejecucion;
use App\Models\Informe;
use App\Models\Mano_obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Mano_ObrasController extends Controller
{
    public function index(){
        $informes = DB::table('informes')
        ->join('ejecucions', 'ejecucions.informe_id', '=', 'informes.id')
        ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
        ->select('informes.id as id_informe',
                'solicituds.id as id_solicitud',
                'solicituds.nombre_sol as nombre_sol',
                'solicituds.zona_sol as zona_sol',
                'ejecucions.id as id_ejecucion',
                'ejecucions.fecha_progrmada as fecha_programada',
                'informes.estado_in as estado',
                'informes.reservorio as reservorio')
        // ->where('informes.estado_in','registrado')
        ->where('informes.estado_in','programado')
        ->get();
        return view('mano_obras.index', compact('informes'));
    }

    public function create($id_ejecucion){
        $ejecucion= Ejecucion::find($id_ejecucion);
        $mano_obra = Mano_obra::all();
        return view('mano_obras.create', compact('ejecucion','mano_obra'));
        // return $ejecucion;
    }

    public function store(Request $request){
        $ejecucion = DB::table('ejecucions')
        ->join('ejecucions', 'ejecucions.informe_id', '=', 'informes.id')
        ->select('informes.id as id')
        ->where('ejecucions.id', '=',$request->id_ejecucion)->first();

        $informe = Informe::find($ejecucion->id);
        $informe->estado_in = 'ejecutado';
        $informe->save();

        $mano = new Mano_obra();
        $mano->descripcion = $request->descripcion;
        $mano->unidad = $request->unidad;
        $mano->cantidad = $request->cantidad;
        $mano->precio_uni = $request->precio_uni;
        $mano->id_ejecucion = $request->id_ejecucion;
        $mano->save();

    }

    public function eliminar(Mano_obra $mano){
        $mano->delete();
        return redirect('mano_obra.create', $mano->ejecucion_id);
    }
}
