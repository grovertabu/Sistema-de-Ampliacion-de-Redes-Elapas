<?php

namespace App\Http\Controllers;

use App\Models\Actividad_mano_obra;
use Illuminate\Http\Request;

class ActividadManoObraController extends Controller
{
    public function index()
    {
        $actividads = Actividad_mano_obra::all();
        return view('actividad_descargo.index', compact('actividads'));
    }


    public function create()
    {
        return view('actividad_descargo.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|unique:actividad_mano_obras|max:255',
            'unidad_medida' => 'required',
            'precio' => 'required|min:0.01'
        ]);
        $actividad = new Actividad_mano_obra();
        $actividad->descripcion = $request->descripcion;
        $actividad->unidad_medida = $request->unidad_medida;
        $actividad->precio_unitario = $request->precio;
        $actividad->save();
        return redirect()->route('actividad.index');
    }


    public function show($id)
    {
        //
    }


    public function edit(Actividad_mano_obra $actividad)
    {
        return view('actividad_descargo.edit', compact('actividad'));
    }


    public function update(Request $request, Actividad_mano_obra $actividad)
    {
        $request->validate([
            'descripcion' => 'required|max:255',
            'unidad_medida' => 'required',
            'precio' => 'required|min:0.01'
        ]);
        $actividad->descripcion = $request->descripcion;
        $actividad->unidad_medida = $request->unidad_medida;
        $actividad->precio_unitario = $request->precio;
        $actividad->save();
        return redirect()->route('actividad.index');
    }

    public function destroy(Actividad_mano_obra $actividad)
    {
        // $actividad->estado = "no disponible";
        $actividad->delete();
        return redirect()->route('actividad.index');
    }
}
