<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public function index()
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
                'informes.estado_in as estado_in',
                'solicituds.x_aprox as x_aprox',
                'solicituds.y_aprox as y_aprox',

            )
            ->where('informes.estado_in', 'firmado')
            ->orWhere('informes.estado_in', 'ejecutando')
            ->orWhere('informes.estado_in', 'en proyeccion')
            ->get();
        return view('monitoreo.index', compact('solicitudall'));
    }

    public function proyectista_reporte()
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
                'informes.estado_in as estado_in',
                'solicituds.x_aprox as x_aprox',
                'solicituds.y_aprox as y_aprox',

            )
            ->where('informes.estado_in', 'firmado')
            ->orWhere('informes.estado_in', 'ejecutando')
            ->orWhere('informes.estado_in', 'en proyeccion')
            ->get();
        return view('monitoreo.reporte');
    }
}
