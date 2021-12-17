<?php

namespace App\Http\Controllers;

use App\Models\Actividad_mano_obra;
use App\Models\Material;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public function index()
    {
        $solicitudall = DB::table('solicituds')
            ->leftJoin('informes', 'solicituds.id', '=', 'informes.solicitud_id')
            ->select(
                'solicituds.id as solicitud_id',
                'solicituds.nombre_sol as nombre_sol',
                'solicituds.celular_sol as celular_sol',
                'solicituds.zona_sol as zona_sol',
                'solicituds.calle_sol as calle_sol',
                'solicituds.estado_sol as estado_sol',
                'informes.id as informe_id',
                'informes.estado_in as estado_in',
                'solicituds.x_aprox as x_aprox',
                'solicituds.y_aprox as y_aprox',
            )
            ->get();
        return view('monitoreo.index', compact('solicitudall'));
    }


    public function proyectista_index()
    {
        $solicitudall = DB::table('solicituds')
            ->leftJoin('informes', 'solicituds.id', '=', 'informes.solicitud_id')
            ->select(
                'solicituds.nombre_sol as nombre_sol',
                'solicituds.celular_sol as celular_sol',
                'solicituds.zona_sol as zona_sol',
                'solicituds.calle_sol as calle_sol',
                'solicituds.estado_sol as estado_sol',
                'informes.id as informe_id',
                'informes.solicitud_id as solicitud_id',
                'informes.ubicacion_geo as ubicacion',
                'informes.estado_in as estado_in',
                'solicituds.x_aprox as x_aprox',
                'solicituds.y_aprox as y_aprox',

            )
            ->where('informes.estado_in', 'firmado')
            ->orWhere('informes.estado_in', 'ejecutado')
            ->orWhere('informes.estado_in', 'ejecutandose')
            ->get();
        return view('monitoreo.index', compact('solicitudall'));
    }

    public function proyectista_reporte()
    {
        $materials = Material::all();
        $mano_obras = Actividad_mano_obra::all();
        return view('monitoreo.reporte', compact('materials', 'mano_obras'));
    }

    public function reporte_ampliaciones()
    {
        $inspectores = User::select(
            'users.id as id_inspector',
            'users.name as nombre_inspector'
        )->where('tipo_user', 'Inspector')->get();
        return view('monitoreo.reporte_ampliaciones', compact('inspectores'));
    }
}
