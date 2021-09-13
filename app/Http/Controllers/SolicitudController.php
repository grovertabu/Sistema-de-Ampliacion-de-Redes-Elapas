<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use PDF;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function index(){
        $solicitud = Solicitud::where('estado_sol','pendiente')->get();
        return view('solicitud.index',compact('solicitud'));
    }
    public function reject(){
        $solicitud = Solicitud::where('estado_sol','rechazado')->get();
        return view('solicitud.index',compact('solicitud'));
    }
    
    public function create(){
        return view('solicitud.create');
    }
    public function store(Request $request){
        $request->validate([
            'nombre_sol'=>'required',
            'celular_sol'=>'required',
            'zona_sol'=>'required',
            'calle_sol'=>'required',
        ]);

        $sol = new Solicitud();
        $sol->nombre_sol = $request->nombre_sol;
        $sol->celular_sol = $request->celular_sol;
        $sol->zona_sol = $request->zona_sol;
        $sol->calle_sol = $request->calle_sol;
        $sol->fecha_sol = $request->fecha_sol;
        $sol->estado_sol = $request->estado_sol;
        $sol->x_aprox = $request->x_aprox;
        $sol->y_aprox = $request->y_aprox;
        $sol->save();
        return redirect()->route('solicitud.index')->with('crear','ok');
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
        return redirect()->route('solicitud.index')->with('aprobar', 'Ok');
        // return $solicitud->estado_sol;
    }
    public function rechazar(Request $request, Solicitud $solicitud){
        
        $solicitud->estado_sol = "rechazado";
        if(strlen($request->observaciones) > 0 ){
            $solicitud->observaciones = $request->observaciones;
        }
        $solicitud->save();
        return redirect()->route('solicitud.index');
        
    }
    public function destroy(Solicitud $solicitud){
        $solicitud->delete();
        return redirect()->route('solicitud.index')->with('eliminar','Ok');
    }

    public function PDF_rechazado(Solicitud $solicitud){
        $pdf = PDF::loadview('PDF/reporte_rechazado',compact('solicitud'));
        return $pdf->stream('Informe Rechazado.pdf');
    }
}
