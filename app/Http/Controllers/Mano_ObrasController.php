<?php

namespace App\Http\Controllers;

use App\Models\Actividad_mano_obra;
use App\Models\Ejecucion;
use App\Models\Informe;
use App\Models\Mano_obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Mano_ObrasController extends Controller
{


    public function create($id_ejecucion){
        $ejecucion= Ejecucion::find($id_ejecucion);
        $mano_obra = DB::table('mano_obras')
                    ->join('actividad_mano_obras','actividad_mano_obras.id', '=','mano_obras.actividad_id')
                    ->select('actividad_mano_obras.descripcion as descripcion',
                            'actividad_mano_obras.unidad_medida as unidad',
                            'mano_obras.id as mano_obras_id',
                            'mano_obras.ancho as ancho',
                            'mano_obras.alto as alto',
                            'mano_obras.largo as largo',
                            'mano_obras.cantidad as cantidad',
                            'mano_obras.precio_uni as precio_uni',
                            'mano_obras.observador as observador')
                    ->where('mano_obras.ejecucion_id', $id_ejecucion)->get();
        $actividad = Actividad_mano_obra::all();
        return view('mano_obras.create', compact('ejecucion','mano_obra','actividad'));
        // return $ejecucion;
    }

    public function store(Request $request){

        $informe = Informe::find($request->id_informe);
        $informe->estado_in = 'ejecutando';
        $informe->save();

        $mano = new Mano_obra();
        $mano->actividad_id = $request->id_actividad;
        $mano->ejecucion_id = $request->id_ejecucion;
        $mano->cantidad = $request->cantidad;
        $mano->precio_uni = $request->precio_uni;
        $mano->ancho = $request->ancho;
        $mano->alto = $request->alto;
        $mano->largo = $request->largo;
        $mano->observador = $request->observador;
        $mano->save();

        return redirect()->route('mano_obra.create', $mano->ejecucion_id);

    }

    public function eliminar($mano_obra){
        $mano = Mano_obra::find($mano_obra);
        $mano->delete();
        return redirect()->route('mano_obra.create', $mano->ejecucion_id);
    }
}
