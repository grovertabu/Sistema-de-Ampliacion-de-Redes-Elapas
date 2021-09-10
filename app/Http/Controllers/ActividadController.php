<?php

namespace App\Http\Controllers;

use App\Models\Actividad_descargo;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index()
    {
        $actividads= Actividad_descargo::all();
        return view('actividad_descargo.index',compact('actividads'));
    }

   
    public function create()
    {
        return view('actividad_descargo.create');
    }


    public function registrar(Request $request)
    {
        $request->validate([
            'nombre_actividad' => 'required|unique:actividad_descargos|max:255',
        ]);
        $actividad = new Actividad_descargo();
        $actividad->nombre_actividad = $request->nombre_actividad;
        $actividad->estado = $request->estado;
        $actividad->save();
        return redirect()->route('actividad.index');
    }


    public function show($id)
    {
        //
    }


    public function edit(Actividad_descargo $actividad)
    {
        return view('actividad_descargo.edit',compact('actividad'));
    }


    public function update(Request $request, Actividad_descargo $actividad)
    {
        $actividad->nombre_actividad = $request->nombre_actividad;
        $actividad->estado = $request->estado;
        $actividad->save();
        return redirect()->route('actividad.index');
    }

    public function destroy( Actividad_descargo $actividad)
    {
        // $actividad->estado = "no disponible";
        $actividad->delete();
        return redirect()->route('actividad.index');
    }
}
