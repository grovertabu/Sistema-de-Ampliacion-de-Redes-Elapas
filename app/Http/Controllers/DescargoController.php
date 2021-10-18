<?php

namespace App\Http\Controllers;

use App\Models\Actividad_descargo;
use App\Models\Aporte_m_vecino;
use App\Models\Compu_metrico_elapa;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Informe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Intl\Idn\Info;

class DescargoController extends Controller
{
    public function index(Request $request)
    {
        $inspectores = User::where('tipo_user', 'inspector')->get();
        $valor = $request->user_id;
        $fecha_descargo = $request->fecha_d;
        if (!empty($request->fecha_d)) {
            if ($valor == 0) {
                $descargos = DB::table('informes')
                    ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                    ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                    ->join('users', 'cronogramas.user_id', '=', 'users.id')
                    ->select(
                        'solicituds.zona_sol as zona',
                        'solicituds.nombre_sol as nombre_sol',
                        'users.name as name',
                        'informes.estado_in as estado',
                        'informes.id as id_informe'
                    )
                    ->where('informes.estado_in', 'firmado')
                    ->whereDate('informes.fecha_hora_in', $request->fecha_d)
                    ->get();
            } else {
                $descargos = DB::table('informes')
                    ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                    ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                    ->join('users', 'cronogramas.user_id', '=', 'users.id')
                    ->select(
                        'solicituds.zona_sol as zona',
                        'solicituds.nombre_sol as nombre_sol',
                        'users.name as name',
                        'informes.estado_in as estado',
                        'informes.id as id_informe'
                    )
                    ->where('informes.estado_in', 'firmado')
                    ->whereDate('informes.fecha_hora_in', $request->fecha_d)
                    ->Where('users.id', $request->user_id)
                    ->get();
            }
        } else {
            $descargos = '';
        }
        return view('descargos.index', compact('descargos', 'inspectores', 'fecha_descargo', 'valor'));
    }
    //----------------------------------Registrar informe de descargo de materiales
    public function mostrar_aportes_v($id_informe, $fecha_descargo, $valor)
    {
        $informe = Informe::find($id_informe);
        $aportes = DB::table('informes')
            ->join('aporte_m_vecinos', 'informes.id', '=', 'aporte_m_vecinos.informe_id')
            ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
            ->select(
                'solicituds.nombre_sol as nombre',
                'solicituds.zona_sol as zona',
                'aporte_m_vecinos.u_medida as unidad',
                'aporte_m_vecinos.cantidad as cantidad',
                'aporte_m_vecinos.id as id_aporte',
                'aporte_m_vecinos.precio_unitario as p_unitario'
            )
            ->where('informes.id', $id_informe)
            ->get();
        return view('aporte_m_vecinos.index', compact('informe', 'aportes', 'fecha_descargo', 'valor'));
    }
    // -----------------------------------APORTES MATERIALES VECINOS--------------------------------------------------
    public function crear_aport_v($id_informe, $fecha_descargo, $valor)
    {
        $informe = Informe::find($id_informe);

        return view('descargos.crear_aport_v', compact('informe', 'fecha_descargo', 'valor'));
    }
    public function registrar_aporte_v(Request $request)
    {
        $aporte_v = new Aporte_m_vecino();
        $aporte_v->informe_id = $request->id_informe;
        $aporte_v->u_medida  = $request->unidad;
        $aporte_v->cantidad = $request->cantidad;
        $aporte_v->precio_unitario = $request->precio_unitario;
        $aporte_v->save();
        // datos de busqueda del descargo e inspector
        $fecha_d = $request->fecha_descargo;
        $user_id = $request->id_inspector;
        // return $request;
        return redirect()->route('descargo.index', compact('fecha_d', 'user_id'));
    }
    public function eliminar_aporte($id_aporte, $fecha_descargo, $valor)
    {
        // $material_i->delete();
        $aporte = Compu_metrico_elapa::find($id_aporte);
        $aporte->delete();
        $fecha_d = $fecha_descargo;
        $user_id = $valor;
        return redirect()->route('descargo.index', compact('fecha_d', 'user_id'));
    }

    // _______________________________________________________________________________________________________________

    public function mostrar_computos_e($id_informe, $fecha_descargo, $valor)
    {
        $informe = Informe::find($id_informe);
        $computos = DB::table('informes')
            ->join('compu_metrico_elapas', 'informes.id', '=', 'compu_metrico_elapas.informe_id')
            ->join('actividad_descargos', 'actividad_descargos.id', '=', 'compu_metrico_elapas.actividad_descargo_id')
            ->select(
                'compu_metrico_elapas.nro as nro',
                'compu_metrico_elapas.ancho as ancho',
                'compu_metrico_elapas.alto as alto',
                'compu_metrico_elapas.id as id_computo_e',
                'actividad_descargos.nombre_actividad as nombre_a',
                'informes.longitud_in as largo'
            )
            ->where('informes.id', $id_informe)
            ->get();
        return view('computo_elapas.index', compact('informe', 'computos', 'fecha_descargo', 'valor'));
    }

    public function crear_computo_e($id_informe, $fecha_descargo, $valor)
    {
        $informe = Informe::find($id_informe);
        $actividads = Actividad_descargo::all();
        $ultimo_registro = Actividad_descargo::all()->last();
        return view('computo_elapas.computo_elapas', compact('informe', 'actividads', 'fecha_descargo', 'valor', 'ultimo_registro'));
    }
    public function registrar_computo_e(Request $request)
    {
        $computo_e = new Compu_metrico_elapa();
        $computo_e->informe_id = $request->id_informe;
        if ($request->actividad_descargo_id == 0) {
            Actividad_descargo::create(
                [
                    'id' => '$request->actividad_id',
                    'nombre_actividad' => '$request->nombre_actividad'
                ]
            );
            $ultimo_registro = Actividad_descargo::all()->last();
            $computo_e->actividad_descargo_id = $ultimo_registro->id;
        } else {
            $computo_e->actividad_descargo_id  = $request->actividad_descargo_id;
        }
        $computo_e->nro = $request->nro;
        $computo_e->ancho = $request->ancho;
        $computo_e->alto = $request->alto;
        $computo_e->save();
        // datos de busqueda del descargo e inspector
        $fecha_d = $request->fecha_descargo;
        $user_id = $request->id_inspector;
        // return $request;
        return $request;
        // return redirect()->route('descargo.index',compact('fecha_d','user_id'));
    }
    public function eliminar_computo_e($id_computo_e, $fecha_descargo, $valor)
    {
        // $material_i->delete();
        $computo_e = Compu_metrico_elapa::find($id_computo_e);
        $computo_e->delete();
        $fecha_d = $fecha_descargo;
        $user_id = $valor;
        return redirect()->route('descargo.index', compact('fecha_d', 'user_id'));
    }
}
