<?php

namespace App\Http\Controllers;

use App\Models\Ejecucion;
use Illuminate\Http\Request;
use App\Models\Informe;
use App\Models\Solicitud;
use App\Models\Material;
// use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
// use Symfony\Polyfill\Intl\Idn\Info;

class InformeController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $aux = Auth::user()->tipo_user;
        if ($aux == 'Inspector') {
            $informes = DB::table('informes')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->select(
                    'informes.id as id_informe',
                    'solicituds.id as id_solicitud',
                    'solicituds.nombre_sol as nombre_sol',
                    'solicituds.calle_sol as calle_sol',
                    'solicituds.zona_sol as zona_sol',
                    'solicituds.x_aprox as x_aprox',
                    'solicituds.y_aprox as y_aprox',
                    'informes.fecha_hora_in as fecha_inspeccion',
                    'informes.ubicacion_geo as ubicacion',
                    'informes.x_exact as x_exact',
                    'informes.y_exact as y_exact',
                    'informes.estado_in as estado'
                )
                ->where('cronogramas.user_id', $id)
                ->where(function ($query) {
                    $query->where('informes.estado_in', 'asignado')
                        ->orwhere('informes.estado_in', 'inspeccionado');
                })
                ->get();
                return view('informes.index', compact('informes', 'id'));
        } else if ($aux == 'Jefe de red') {
            $informes = DB::table('informes')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->select(
                    'informes.id as id_informe',
                    'solicituds.id as id_solicitud',
                    'solicituds.nombre_sol as nombre_sol',
                    'solicituds.calle_sol as calle_sol',
                    'solicituds.zona_sol as zona_sol',
                    'solicituds.x_aprox as x_aprox',
                    'solicituds.y_aprox as y_aprox',
                    'informes.fecha_hora_in as fecha_inspeccion',
                    'informes.estado_in as estado',
                    'informes.x_exact as x_exact',
                    'informes.y_exact as y_exact',
                    'informes.ubicacion_geo as ubicacion',
                    'cronogramas.user_id as user_id'
                )
                ->where('informes.estado_in', 'asignado')
                ->orWhere('informes.estado_in', 'inspeccionado')

                ->get();
                return view('informes.index', compact('informes', 'id'));
        }
        else{
            abort(403);
        }
        // $informes = Informe::all();

    }


    public function autorizar(Request $request, $id)
    {
        date_default_timezone_set('America/La_Paz');
        $fecha = date('Y-m-d');
        $informe = Informe::find($id);
        $informe->estado_in = "autorizado";
        $informe->fecha_autorizado = $fecha;
        $informe->save();

        $ejecucion = new Ejecucion();
        $ejecucion->fecha_progrmada = $request->fecha_programada;
        $ejecucion->user_id = $request->user_id;
        $ejecucion->informe_id = $informe->id;
        $ejecucion->solicitud_id = $request->solicitud_id;
        $ejecucion->save();

        return redirect()->route('informes.index');
        // return $informe;
    }
    public function no_autorizar(Informe $informe)
    {
        $informe->estado_in = "no autorizado";
        $informe->save();
        return redirect()->route('informes.index');
        // return $solicitud->estado_in;
    }
    public function firmar_informe(Informe $informe)
    {
        $informe->estado_in = "firmado";
        $informe->save();
        return redirect()->route('informes.autorizado');
        // return $solicitud->estado_in;
    }

    public function aprobar_proyecto(Informe $informe)
    {
        date_default_timezone_set('America/La_Paz');
        $fecha = date('Y-m-d');
        $informe->estado_in = "ejecutandose";
        $informe->fecha_visto_bueno = $fecha;
        $informe->save();
        return redirect()->route('proyectos.index');
        // return $solicitud->estado_in;
    }

    public function autorizado()
    {
        $id = Auth::user()->id;
        $aux = Auth::user()->tipo_user;
        if ($aux == 'Inspector') {
            $informes = DB::table('informes')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->leftJoin('ejecucions', 'ejecucions.informe_id', '=', 'informes.id')
                ->select(
                    'solicituds.id as id_solicitud',
                    'solicituds.nombre_sol as nombre_sol',
                    'solicituds.zona_sol as zona_sol',
                    'informes.fecha_hora_in as fecha_inspeccion',
                    'informes.estado_in as estado',
                    'informes.id as id_informe',
                    'informes.x_exact as x_exact',
                    'informes.y_exact as y_exact',
                    'cronogramas.user_id as user_id',
                    'ejecucions.id as id_ejecucion',
                    'ejecucions.fecha_progrmada as fecha_programada',
                    'ejecucions.fecha_ejecutada as fecha_ejecutada'
                )
                ->where('cronogramas.user_id', $id)
                ->where(function ($query) {
                    $query->where('informes.estado_in', 'autorizado')
                        ->orWhere('informes.estado_in', 'firmado');
                })
                ->get();
        } else {
            $informes = DB::table('informes')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->leftJoin('ejecucions', 'ejecucions.informe_id', '=', 'informes.id')
                ->select(
                    'informes.id as id_informe',
                    'solicituds.id as id_solicitud',
                    'solicituds.nombre_sol as nombre_sol',
                    'solicituds.zona_sol as zona_sol',
                    'informes.fecha_hora_in as fecha_inspeccion',
                    'informes.estado_in as estado',
                    'informes.x_exact as x_exact',
                    'informes.y_exact as y_exact',
                    'cronogramas.user_id as user_id',
                    'ejecucions.id as id_ejecucion',
                    'ejecucions.fecha_progrmada as fecha_programada',
                    'ejecucions.fecha_ejecutada as fecha_ejecutada'
                )
                ->where('informes.estado_in', 'autorizado')
                ->orWhere('informes.estado_in', 'firmado')
                ->get();
        }

        return view('informes.autorizado', compact('informes'));
        // return $informes;
    }

    public function concluido()
    {
        $id = Auth::user()->id;
        $aux = Auth::user()->tipo_user;
        if ($aux == 'Inspector') {

            $informes = DB::table('informes')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->join('ejecucions', 'ejecucions.informe_id', '=', 'informes.id')
                ->select(
                    'informes.id as id_informe',
                    'solicituds.id as id_solicitud',
                    'solicituds.nombre_sol as nombre_sol',
                    'solicituds.zona_sol as zona_sol',
                    'informes.fecha_hora_in as fecha_inspeccion',
                    'informes.estado_in as estado',
                    'solicituds.zona_sol as zonal_sol',
                    'solicituds.calle_sol as calle_sol',
                    'ejecucions.id as id_ejecucion',
                    'ejecucions.fecha_ejecutada as fecha_ejecutada'

                )
                ->where('cronogramas.user_id', $id)
                ->where(function ($query) {
                    $query->where('informes.estado_in', 'ejecutandose')
                        ->orWhere('informes.estado_in', 'ejecutado');
                })
                ->get();
        } else {
            $informes = DB::table('informes')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->join('ejecucions', 'ejecucions.informe_id', '=', 'informes.id')
                ->select(
                    'informes.id as id_informe',
                    'solicituds.id as id_solicitud',
                    'solicituds.nombre_sol as nombre_sol',
                    'solicituds.zona_sol as zona_sol',
                    'informes.fecha_hora_in as fecha_inspeccion',
                    'informes.estado_in as estado',
                    'ejecucions.fecha_ejecutada as fecha_ejecutada'

                )
                ->where('informes.estado_in', 'ejecutandose')
                ->orWhere('informes.estado_in', 'ejecutado')
                ->get();
        }

        return view('informes.concluido', compact('informes'));
        // return $informes;
    }


    public function create()
    {
        $solicitud = Solicitud::all();
        return view('informes.create', compact('solicitud'));
    }

    public function store(Request $request)
    {
        $informe = new Informe();
        $informe->fecha_hora_in = $request->fecha_hora_in;
        $informe->espesifiar_in = $request->espesifiar_in;
        $informe->x_exact = $request->x_exact;
        $informe->y_exact = $request->y_exact;
        $informe->ubicacion_geo = $request->ubicacion_geo;
        $informe->longitud_in = $request->longitud_in;
        $informe->diametro_in = $request->diametro_in;
        $informe->num_ben_in = $request->num_ben_in;
        $informe->num_flia_in = $request->num_flia_in;
        $informe->reservorio = $request->reservorio;
        $informe->condicion_rasante = $request->condicion_rasante;
        $informe->estado_in = $request->estado_in;
        $informe->solicitud_id = $request->solicitud_id;
        $informe->imagen_amp = 'informe_' + $request->solicitud_id + '.png';

        $image_64 = $request->textMap;
        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);
        Storage::disk('public')->put('informe_' + $request->solicitud_id + '.png', base64_decode($image));
        //return var_dump($informe);
        $informe->save();
        return redirect()->route('informes.index');
    }

    public function show(Informe $informe)
    {
        $mat_inf = DB::table('materials')
            ->join('informe_materials', 'materials.id', '=', 'informe_materials.material_id')
            ->join('informes', 'informes.id', '=', 'informe_materials.informe_id')
            ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
            ->select(
                'informe_materials.id as id',
                'informes.id as id_i',
                'materials.nombre_material as material_n',
                'solicituds.nombre_sol as nombre_sol',
                'informe_materials.cantidad as cantidad',
                'informe_materials.u_medida as u_medida'
            )
            ->where('materials.estado', 'disponible')
            ->where('informes.id', $informe->id)
            ->get();
        $materials = Material::where('estado', 'disponible')->get();
        return view('material_informe.index', compact('mat_inf', 'materials', 'informe'));
    }

    public function registrar_material(Informe $informe)
    {
        $materials = Material::where('estado', 'disponible')->get();
        $mat_inf = DB::table('materials')
            ->join('informe_materials', 'materials.id', '=', 'informe_materials.material_id')
            ->join('informes', 'informes.id', '=', 'informe_materials.informe_id')
            ->select(
                'informe_materials.id as id',
                'informes.id as id_i',
                'materials.nombre_material as material_n',
                'informe_materials.cantidad as cantidad',
                'materials.unidad_med as unidad',
                'informe_materials.precio_unitario as precio',
                'informe_materials.observador as observador',
            )
            ->where('materials.estado', 'disponible')
            ->where('informes.id', $informe->id)
            ->get();


        return view('material_informe.create', compact('materials'), compact('informe', 'mat_inf'));
        // return $informe;
    }

    public function edit(Informe $informe)
    {
        // return $informe;
        return view('informes.edit', compact('informe'));
    }

    public function update(Request $request, Informe $informe)
    {
        $request->validate([
            'fecha_hora_in' => 'required',
            'espesifiar_in' => 'required',
            'x_exact' => 'required',
            'y_exact' => 'required',
            'ubicacion_geo' => 'required',
            'longitud_in' => 'required',
            'diametro_in' => 'required',
            'num_ben_in' => 'required',
            'num_flia_in' => 'required',
            'condicion_rasante' => 'required',
            'reservorio' => 'required',
            'solicitud_id' => 'required'
        ]);
        $informe->fecha_hora_in = $request->fecha_hora_in;
        $informe->espesifiar_in = $request->espesifiar_in;
        $informe->x_exact = $request->x_exact;
        $informe->y_exact = $request->y_exact;
        $informe->ubicacion_geo = $request->ubicacion_geo;
        $informe->longitud_in = $request->longitud_in;
        $informe->diametro_in = $request->diametro_in;
        $informe->num_ben_in = $request->num_ben_in;
        $informe->num_flia_in = $request->num_flia_in;
        $informe->condicion_rasante = $request->condicion_rasante;
        $informe->reservorio = $request->reservorio;
        $informe->estado_in = 'inspeccionado';
        $informe->solicitud_id = $request->solicitud_id;
        $informe->imagen_amp = 'informe_' . $request->solicitud_id . '.png';
        if ($request->textMap != null) {
            $image_64 = $request->textMap;
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            $image = str_replace($replace, '', $image_64);

            $image = str_replace(' ', '+', $image);
            Storage::disk('public')->put('informe_' . $request->solicitud_id . '.png', base64_decode($image));
        }
        $informe->save();
        return redirect()->route('informes.index');
    }


    public function destroy($id)
    {
        //
    }
}
