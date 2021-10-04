<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Match_;

class MaterialController extends Controller
{
    
    public function index()
    {
        $materials = Material::all();
        return view('materials.index',compact('materials'));
    }

   
    public function create()
    {
        return view('materials.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre_material' => 'required|unique:materials|max:255',
        ]);
        $material = new Material();
        $material->nombre_material = $request->nombre_material;
        $material->observaciones = $request->observaciones;
        $material->precio_unitario = $request->precio_unitario;
        $material->estado = $request->estado;
        $material->unidad_med = $request->unidad_medida;
        $material->save();
        return redirect()->route('materials.index');
    }


    public function show($id)
    {
        //
    }


    public function edit(Material $material)
    {
        return view('materials.edit',compact('material'));
    }


    public function update(Request $request, Material $material)
    {
        $material->nombre_material = $request->nombre_material;
        $material->observaciones = $request->observaciones;
        $material->estado = $request->estado;
        $material->save();
        return redirect()->route('materials.index');
    }

    public function destroy( Material $material)
    {
        // $material->estado = "no disponible";
        $material->delete();
        return redirect()->route('materials.index');
    }

}
