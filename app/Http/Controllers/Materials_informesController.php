<?php

namespace App\Http\Controllers;
use App\Models\Material;
use App\Models\Informe;
use App\Models\Informe_material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Materials_informesController extends Controller
{
    public function index()
    {
        $mat_inf = DB::table('materials')
                ->join('informe_materials', 'materials.id', '=', 'informe_materials.material_id')
                ->join('informes', 'informes.id', '=', 'informe_materials.informe_id')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->select('informe_materials.id as id',
                        'informes.id as id_i',
                        'materials.nombre_material as material_n',
                        'solicituds.nombre_sol as nombre_sol',
                        'informe_materials.cantidad as cantidad',
                        'informe_materials.estado as estado')
                ->where('materials.estado','disponible')
                ->where('informes.id','1')
                ->get();
            // $informes = Informe::where('id','1')->get();
            return view('material_informe.index',compact('mat_inf'));
    }

    public function show(Informe_material $material_informe){
        $mat_inf = DB::table('materials')
                ->join('material_informes', 'materials.id', '=', 'material_informes.material_id')
                ->join('informes', 'informes.id', '=', 'material_informes.informe_id')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->select('material_informes.id as id',
                        'informes.id as id_i',
                        'materials.nombre_material as material_n',
                        'solicituds.nombre_sol as nombre_sol',
                        'material_informes.cantidad as cantidad',
                        'material_informes.estado as estado')
                ->where('materials.estado','disponible')
                ->where('informes.id',$material_informe->informe_id)
                ->get();
        return $mat_inf;
    }
    public function create()
    {
        
        $materials = Material::where('estado','disponible')->get();
        $informes = Informe::all();
        return view('material_informe.create',compact('materials'),compact('informes'));
    }


    public function store(Request $request)
    {
        $mat_inf = new Informe_material();
        $mat_inf->informe_id  = $request->id_informe;
        $mat_inf->material_id = $request->id_material;
        $mat_inf->cantidad    = $request->cantidad;
        $mat_inf->u_medida    = $request->u_medida;
        $mat_inf->save();
        return redirect()->route('informes.autorizado');
    }


    public function destroy($material_i){
        // $material_i->delete();
        $mat_inf = Informe_material::find($material_i);
        $mat_inf->delete();
        return redirect()->route('informes.autorizado');
    }

}
