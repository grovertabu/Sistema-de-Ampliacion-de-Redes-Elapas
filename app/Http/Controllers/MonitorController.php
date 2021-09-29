<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public function index(){
        $solicitudall = DB::table('solicituds')
        ->leftJoin('informes', 'solicituds.id', '=', 'informes.solicitud_id')->get();
        return view('monitoreo.index',compact('solicitudall'));
    }
}
