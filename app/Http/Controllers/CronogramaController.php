<?php

namespace App\Http\Controllers;

use App\Models\Cronograma;
use App\Models\Informe;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CronogramaController extends Controller
{
    
    public function index(){
        $inspectores = User::where('tipo_user','Inspector')->get();
        $solicitud = Solicitud::where('estado_sol','aprobado')->get();
        $solicitudall = Informe::all();
        return view('cronograma.index',compact('solicitud','inspectores','solicitudall'));
    }

    public function mostrar(Request $request){
        $valor=$request->user_id;
        $fecha_inspeccion=$request->fecha_i;
        if (!empty($request->fecha_i)) {
            if ($valor==0) {
                // 10
                // se crea una evaluacion vacia
                // esa evaluacion se muestre 
                $cronogramas = DB::table('informes')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->join('users', 'cronogramas.user_id', '=', 'users.id')
                ->select('solicituds.zona_sol as zona',
                        'solicituds.nombre_sol as nombre_sol',
                        'solicituds.celular_sol as celular',
                        'users.name as name',
                        'cronogramas.fecha_inspe as fecha_inspe')
                ->where('cronogramas.estado','asignado')
                ->whereDate('cronogramas.fecha_inspe',$request->fecha_i)
                ->get();
            }
            else{
            $cronogramas = DB::table('informes')
                    ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                    ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                    ->join('users', 'cronogramas.user_id', '=', 'users.id')
                    ->select('solicituds.zona_sol as zona',
                            'solicituds.nombre_sol as nombre_sol',
                            'solicituds.celular_sol as celular',
                            'users.name as name',
                            'cronogramas.fecha_inspe as fecha_inspe')
                    ->where('cronogramas.estado','asignado')
                    ->whereDate('cronogramas.fecha_inspe',$request->fecha_i)
                    ->Where('users.id',$request->user_id)
                    ->get();
            }
        }
        else{
            $cronogramas='';
        }

        $inspectores = User::where('tipo_user','inspector')->get();

        return view('cronograma.cronograma',compact('cronogramas','fecha_inspeccion','valor','inspectores'));
    }
    

    public function create(){
        return view('cronograma.create');
    }
    public function store(Request $request){
        $request->validate([
            'fecha_inspe'=>'required|unique:cronogramas',
            'solicitud_id'=>'required|unique:cronogramas',
        ]);
        $cronograma= new Cronograma();
        $cronograma->user_id=$request->user_id;
        $cronograma->solicitud_id=$request->solicitud_id;
        $cronograma->fecha_inspe=$request->fecha_inspe;
        $cronograma->estado="asignado";
        $cronograma->save();

        $informe = new Informe();
       
        $informe->estado_in = 'asignado';
        $informe->fecha_hora_in= $request->fecha_inspe;
        $informe->solicitud_id = $request->solicitud_id;
        $informe->save();

        $solicitud= Solicitud::find($request->solicitud_id);
        $solicitud->estado_sol='asignado';
        $solicitud->save();
        return redirect()->route('cronograma.index');
        // return $request;
    }

    public function edit(Solicitud $solicitud){
        return view('solicitud.edit',compact('solicitud'));
    }
    
    public function update(Request $request, Solicitud $solicitud){
        $solicitud->nombre_sol = $request->nombre_sol;
        $solicitud->celular_sol = $request->celular_sol;
        $solicitud->zona_sol = $request->zona_sol;
        $solicitud->calle_sol = $request->calle_sol;
        $solicitud->fecha_sol = $request->fecha_sol;
        $solicitud->estado_sol = $request->estado_sol;
        $solicitud->x_aprox = $request->x_aprox;
        $solicitud->y_aprox = $request->y_aprox;
        $solicitud->save();
        return redirect()->route('solicitud.index');
    }
    public function aprobar(Solicitud $solicitud){
        $solicitud->estado_sol = "aprobado";
        $solicitud->save();
        return redirect()->route('solicitud.index');
        // return $solicitud->estado_sol;
    }
    public function rechazar(Solicitud $solicitud){
        $solicitud->estado_sol = "rechazado";
        $solicitud->save();
        return redirect()->route('solicitud.index');
        // return $solicitud->estado_sol;
    }
    public function destroy(Solicitud $solicitud){
        $solicitud->delete();
        return redirect()->route('solicitud.index')->with('eliminar','Ok');
    }
}
