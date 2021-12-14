<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SolicitudController extends Controller
{
    public function index()
    {
        $solicitud = Solicitud::where('estado_sol', 'pendiente')->get();
        return view('solicitud.index', compact('solicitud'));
    }
    public function reject()
    {
        $solicitud = Solicitud::where('estado_sol', 'rechazado')->get();
        return view('solicitud.index', compact('solicitud'));
    }

    public function create()
    {
        return view('solicitud.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre_sol' => 'required',
            'celular_sol' => 'required',
            'zona_sol' => 'required',
            'calle_sol' => 'required',
            'x_aprox' => 'required',
            'y_aprox' => 'required',
            'sol_escaneada' => 'required'
        ]);
        $sol_anterior = DB::table('solicituds')->orderby('created_at', 'DESC')->take(1)->get();;
        $sol = new Solicitud();
        $sol->nombre_sol = $request->nombre_sol;
        $sol->celular_sol = $request->celular_sol;
        $sol->zona_sol = $request->zona_sol;
        $sol->calle_sol = $request->calle_sol;
        $sol->fecha_sol = $request->fecha_sol;
        $sol->estado_sol = $request->estado_sol;
        $sol->x_aprox = $request->x_aprox;
        $sol->y_aprox = $request->y_aprox;
        if ($request->hasFile('sol_escaneada')) {
            if ($request->file('sol_escaneada')->isValid()) {
                $file = $request->file('sol_escaneada');
                $nombre = $sol_anterior->isEmpty() ? 1 : $sol_anterior[0]->id + 1;
                $sol->sol_escaneada = 'solicitud_' . $nombre . '.png';
                Storage::disk('solicitudes')->put($sol->sol_escaneada,  File::get($file));
            }
            $sol->save();
        }
        return redirect()->route('solicitud.index')->with('crear', 'ok');
    }

    public function edit(Solicitud $solicitud)
    {
        return view('solicitud.edit', compact('solicitud'));
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'nombre_sol' => 'required',
            'celular_sol' => 'required',
            'zona_sol' => 'required',
            'calle_sol' => 'required',
            'x_aprox' => 'required',
            'y_aprox' => 'required'
        ]);
        $solicitud->nombre_sol = $request->nombre_sol;
        $solicitud->celular_sol = $request->celular_sol;
        $solicitud->zona_sol = $request->zona_sol;
        $solicitud->calle_sol = $request->calle_sol;
        $solicitud->fecha_sol = $request->fecha_sol;
        $solicitud->estado_sol = $request->estado_sol;
        $solicitud->x_aprox = $request->x_aprox;
        $solicitud->y_aprox = $request->y_aprox;
        if ($request->hasFile('sol_escaneada')) {
            if ($request->file('sol_escaneada')->isValid()) {
                $file = $request->file('sol_escaneada');
                $nombre = 'solicitud_' . $solicitud->id;
                $solicitud->sol_escaneada = $nombre . '.png';
                Storage::disk('solicitudes')->put($solicitud->sol_escaneada,  File::get($file));
            }
        }
        $solicitud->save();
        return redirect()->route('solicitud.index');
    }
    public function aprobar(Solicitud $solicitud)
    {
        $solicitud->estado_sol = "aprobado";
        $solicitud->save();
        return redirect()->route('solicitud.index')->with('aprobar', 'Ok');
        // return $solicitud->estado_sol;
    }
    public function form_rechazado($id)
    {
        $solicitud = Solicitud::select(
            'solicituds.id as id',
            'solicituds.x_aprox as x_aprox',
            'solicituds.y_aprox as y_aprox'
        )->where('solicituds.id', $id)->first();
        return view('solicitud.rechazar', compact('solicitud'));
    }
    public function rechazar(Request $request)
    {
        $solicitud = Solicitud::find($request->id_solicitud);
        $solicitud->sol_rechazada = 'rechazada_' . $solicitud->id . '.png';
        $solicitud->estado_sol = "rechazado";
        if (strlen($request->observaciones) > 0) {
            $solicitud->observaciones = $request->observaciones;
        }
        $image_64 = $request->textMap;
        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);
        Storage::disk('rechazadas')->put($solicitud->sol_rechazada, base64_decode($image));
        //return var_dump($informe);
        $solicitud->save();
        return redirect()->route('solicitud.index');
    }
    public function destroy(Solicitud $solicitud)
    {
        $solicitud->delete();
        return redirect()->route('solicitud.index')->with('eliminar', 'Ok');
    }

    public function PDF_rechazado(Solicitud $solicitud)
    {
        return view('PDF/reporte_rechazado', compact('solicitud'));
    }

    public function guardarAmpliacion(Request $request, Solicitud $solicitud)
    {
        $solicitud->ampliaciones = $request->ampliaciones;
        $solicitud->save();

        return var_dump($request->ampliaciones);
    }

    public function obtenerAmpliacion(Solicitud $solicitud)
    {


        return ["ampliacion" => $solicitud->ampliaciones];
    }
}
