<?php

namespace App\Http\Controllers;

use App\Models\Informe;
use App\Models\Informe_material;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function PDF(Informe $informe)
    {
        //$pdf = PDF::loadview('PDF/informe',compact('informe'));
        //return $pdf->stream('Informe.pdf');
        // return $informe;
        if ($informe->imagen_amp != null) {

            return view('PDF.informe', compact('informe'));
        } else {
            return view('PDF.informe', compact('informe'));
            // $pdf = PDF::loadview('PDF/informe', compact('informe'));
            // return $pdf->stream('Informe.pdf');
        }
    }

    public function PDF_informe_material(Informe $informe)
    {

        $inspector = DB::table('users')
            ->join('cronogramas', 'users.id', '=', 'cronogramas.user_id')
            ->join('solicituds', 'solicituds.id', '=', 'cronogramas.solicitud_id')
            ->join('informes', 'informes.solicitud_id', '=', 'solicituds.id')
            ->where('informes.id', $informe->id)
            ->select('users.name as nombre_inspector')
            ->get();

        $materiales = DB::table('informe_materials')
            ->join('materials', 'informe_materials.material_id', '=', 'materials.id')
            ->select(
                'informe_materials.cantidad as cantidad',
                'informe_materials.u_medida as u_medida',
                'informe_materials.observador as observador',
                'informe_materials.precio_unitario as precio_unitario',
                'materials.nombre_material as nombre_material'
            )
            ->where('informe_materials.informe_id', $informe->id)
            ->get();
        $mano_obra = DB::table('mano_obras')
            ->join('ejecucions', 'ejecucions.id', '=', 'mano_obras.ejecucion_id')
            ->join('actividad_mano_obras', 'actividad_mano_obras.id', '=', 'mano_obras.actividad_id')
            ->select(
                'actividad_mano_obras.descripcion as descripcion',
                'actividad_mano_obras.unidad_medida as unidad',
                'mano_obras.cantidad as cantidad',
                'mano_obras.precio_uni as precio_unitario',
                'mano_obras.observador as observador'
            )
            ->where('ejecucions.informe_id', $informe->id)
            ->get();

        // $pdf = PDF::loadview('PDF/informe_material', compact('informe', 'materiales', 'inspector', 'mano_obra'));
        // return $pdf->stream('Informe_material.pdf');

        return view('PDF.informe_material', compact('informe', 'materiales', 'inspector', 'mano_obra'));

        // return $informe;
    }

    public function PDF_informe_descargo_material(Informe $informe)
    {
        $inspector = DB::table('users')
            ->join('cronogramas', 'users.id', '=', 'cronogramas.user_id')
            ->join('solicituds', 'solicituds.id', '=', 'cronogramas.solicitud_id')
            ->join('informes', 'informes.solicitud_id', '=', 'solicituds.id')
            ->join('ejecucions', 'ejecucions.informe_id', '=', 'informes.id')
            ->where('informes.id', $informe->id)
            ->select(
                'users.name as nombre_inspector',
                'solicituds.fecha_sol as fecha_sol',
                'solicituds.zona_sol as zona_sol',
                'solicituds.calle_sol as calle_sol',
                'ejecucions.fecha_ejecutada as fecha_ejecutada'
            )
            ->first();

        $materiales = DB::table('informe_materials')
            ->join('materials', 'informe_materials.material_id', '=', 'materials.id')
            ->select(
                'informe_materials.cantidad as cantidad',
                'informe_materials.u_medida as u_medida',
                'informe_materials.observador as observador',
                'informe_materials.precio_unitario as precio_unitario',
                'materials.nombre_material as nombre_material'
            )
            ->where('informe_materials.informe_id', $informe->id)
            ->get();
        $mano_obra = DB::table('mano_obras')
            ->join('ejecucions', 'ejecucions.id', '=', 'mano_obras.ejecucion_id')
            ->join('actividad_mano_obras', 'actividad_mano_obras.id', '=', 'mano_obras.actividad_id')
            ->select(
                'actividad_mano_obras.descripcion as descripcion',
                'actividad_mano_obras.unidad_medida as unidad',
                'mano_obras.cantidad as cantidad',
                'mano_obras.precio_uni as precio_unitario',
                'mano_obras.observador as observador',
                'mano_obras.alto as alto',
                'mano_obras.ancho as ancho',
                'mano_obras.largo as largo'
            )
            ->where('ejecucions.informe_id', $informe->id)
            ->get();

        // $pdf = PDF::loadview('PDF.descargo_materiales_reporte', compact('informe', 'materiales', 'inspector', 'mano_obra'));
        // return $pdf->stream('Reporte_Descargo_Material.pdf');

        return view('PDF.descargo_materiales_reporte', compact('informe', 'materiales', 'inspector', 'mano_obra'));
    }

    public function PDF_pedido(Informe $informe)
    {
        $materiales = DB::table('informe_materials')
            ->join('materials', 'informe_materials.material_id', '=', 'materials.id')

            ->select(
                'informe_materials.cantidad as cantidad',
                'informe_materials.u_medida as u_medida',
                'materials.nombre_material as nombre_material'
            )
            ->where('informe_materials.informe_id', $informe->id)
            ->where('informe_materials.observador', 'Elapas')
            ->get();
        $inspector = DB::table('informes')
            ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
            ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
            ->join('users', 'cronogramas.user_id', '=', 'users.id')
            ->select('users.name as name', 'informes.estado_in as estado')
            ->where('informes.id', $informe->id)
            ->first();
        $jefe_r = DB::table('users')
            ->where('users.tipo_user', 'Jefe de red')
            ->select('users.name as name')
            ->first();
        // $materiales=DB::select("SELECT m.nombre_material,im.cantidad,im.u_medida FROM informe_materials im
        //                         INNER JOIN materials m on m.id=im.material_id WHERE im.informe_id=1");
        // $pdf = PDF::loadview('PDF/pedido_material',compact('informe','materiales','inspector','jefe_r'));
        // return $pdf->stream('reporte_pedido.pdf');
        return PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadview('PDF/pedido_material', compact('informe', 'materiales', 'inspector', 'jefe_r'))->stream('reporte_pedido.pdf');
        // return $informe;
    }

    public function PDF_cronograma($fecha_inspeccion, $valor)
    {
        if ($valor == 0) {
            $cronogramas = DB::table('informes')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->join('users', 'cronogramas.user_id', '=', 'users.id')
                ->select(
                    'solicituds.zona_sol as zona',
                    'solicituds.nombre_sol as nombre_sol',
                    'users.name as name',
                    'solicituds.celular_sol as celular',
                    'cronogramas.fecha_inspe as fecha_inspe'
                )
                ->where('cronogramas.estado', 'asignado')
                ->whereDate('cronogramas.fecha_inspe', $fecha_inspeccion)
                ->get();
        } else {
            $cronogramas = DB::table('informes')
                ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->join('users', 'cronogramas.user_id', '=', 'users.id')
                ->select(
                    'solicituds.zona_sol as zona',
                    'solicituds.nombre_sol as nombre_sol',
                    'users.name as name',
                    'solicituds.celular_sol as celular',
                    'cronogramas.fecha_inspe as fecha_inspe'
                )
                ->where('cronogramas.estado', 'asignado')
                ->whereDate('cronogramas.fecha_inspe', $fecha_inspeccion)
                ->where('users.id', $valor)
                ->get();
        }
        $pdf = PDF::loadview('PDF.reporte_cronograma', compact('cronogramas', 'fecha_inspeccion'));
        return $pdf->stream('cronograma.pdf');
        // return $cronogramas;
    }
    public function PDF_reporte_pedido(Informe $informe)
    {
        $pdf = PDF::loadview('PDF/informe', compact('informe'));
        return $pdf->stream('Informe.pdf');
        // return $informe;
    }

    public function PDF_proyecto(Informe $informe)
    {
        $inspector = DB::table('informes')
            ->join('solicituds', 'solicituds.id', '=', 'informes.solicitud_id')
            ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
            ->join('users', 'cronogramas.user_id', '=', 'users.id')
            ->select('users.name as nombre')
            ->where('informes.id', $informe->id)
            ->first();
        $materiales = DB::table('informe_materials')
            ->join('materials', 'informe_materials.material_id', '=', 'materials.id')
            ->select(
                'informe_materials.cantidad as cantidad',
                'informe_materials.u_medida as u_medida',
                'informe_materials.observador as observador',
                'informe_materials.precio_unitario as precio_unitario',
                'materials.nombre_material as nombre_material'
            )
            ->where('informe_materials.informe_id', $informe->id)
            ->get();
        $mano_obra = DB::table('mano_obras')
            ->join('ejecucions', 'ejecucions.id', '=', 'mano_obras.ejecucion_id')
            ->join('actividad_mano_obras', 'actividad_mano_obras.id', '=', 'mano_obras.actividad_id')
            ->select(
                'actividad_mano_obras.descripcion as descripcion',
                'actividad_mano_obras.unidad_medida as unidad',
                'mano_obras.cantidad as cantidad',
                'mano_obras.precio_uni as precio_unitario',
                'mano_obras.observador as observador'
            )
            ->where('ejecucions.informe_id', $informe->id)
            ->get();

        // $pdf = PDF::loadview('PDF/proyecto',compact('informe','inspector'));
        // return $pdf->stream('Informe.pdf');
        return view('PDF/proyecto', compact('informe', 'inspector', 'materiales', 'mano_obra'));
        // return $informe;
    }

    public function generar_reporte_proyectista(Request $request)
    {
        $materiales = [];
        $mano_obras = [];
        //dd($request->mano_obra_check);
        if ($request->material_check != null) {
            $materiales = DB::table('materials')
                ->join('informe_materials', 'informe_materials.material_id', '=', 'materials.id')
                ->join('informes', 'informes.id', '=', 'informe_materials.informe_id')
                ->join('ejecucions', 'ejecucions.informe_id', '=', 'informes.id')
                ->whereIn('informe_materials.material_id', $request->material_check)
                ->whereBetween('ejecucions.fecha_ejecutada', [$request->fecha_i, $request->fecha_h])
                ->orderBy('informe_materials.material_id')
                ->get();
        }
        if ($request->mano_obra_check != null) {
            $mano_obras = DB::table('actividad_mano_obras')
                ->join('mano_obras', 'mano_obras.actividad_id', '=', 'actividad_mano_obras.id')
                ->join('ejecucions', 'ejecucions.id', '=', 'mano_obras.ejecucion_id')
                ->whereIn('mano_obras.actividad_id', $request->mano_obra_check)
                ->whereBetween('ejecucions.fecha_ejecutada', [$request->fecha_i, $request->fecha_h])
                ->orderBy('mano_obras.actividad_id')
                ->get();
        }
        $fecha_i = $request->fecha_i;
        $fecha_h = $request->fecha_h;
        return response(compact('mano_obras', 'materiales', 'fecha_i', 'fecha_h'));
        // $pdf = PDF::loadview('PDF/informe', compact('informe'));
        //return $pdf->stream('Informe.pdf');
    }
    public function solicitud_escaneada($id)
    {
        $solicitud = Solicitud::find($id);
        return view('PDF/solicitud_escaneada', compact('solicitud'));
    }

    public function generar_reporte_ampliaciones(Request $request)
    {
        if ($request->user_id == 0) {
            $ampliaciones = DB::table('solicituds')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->join('users', 'users.id', '=', 'cronogramas.user_id')
                ->leftJoin('informes', 'solicituds.id', '=', 'informes.solicitud_id')
                ->leftJoin('ejecucions', 'solicituds.id', '=', 'ejecucions.solicitud_id')
                ->select(
                    'solicituds.id as id_sol',
                    'solicituds.nombre_sol as solicitante',
                    'solicituds.zona_sol as zona',
                    'informes.fecha_hora_in as fecha_inspeccion',
                    'users.name as nombre',
                    'informes.fecha_autorizacion as fecha_autorizacion',
                    'informes.fecha_visto_bueno as fecha_visto_bueno',
                    'informes.estado_in as estado',
                    'informes.longitud_in as longitud',
                    'ejecucions.fecha_ejecutada as fecha_ejecutada'

                )
                ->whereBetween('solicituds.fecha_sol', [$request->fecha_i, $request->fecha_h])
                ->get();
        } else {
            $ampliaciones = DB::table('solicituds')
                ->join('cronogramas', 'cronogramas.solicitud_id', '=', 'solicituds.id')
                ->join('users', 'users.id', '=', 'cronogramas.user_id')
                ->leftJoin('informes', 'solicituds.id', '=', 'informes.solicitud_id')
                ->leftJoin('ejecucions', 'solicituds.id', '=', 'ejecucions.solicitud_id')
                ->select(
                    'solicituds.id as id_sol',
                    'solicituds.nombre_sol as solicitante',
                    'solicituds.zona_sol as zona',
                    'informes.fecha_hora_in as fecha_inspeccion',
                    'users.name as nombre',
                    'informes.fecha_autorizacion as fecha_autorizacion',
                    'informes.fecha_visto_bueno as fecha_visto_bueno',
                    'informes.estado_in as estado',
                    'informes.longitud_in as longitud',
                    'ejecucions.fecha_ejecutada as fecha_ejecutada'

                )
                ->where('cronogramas.user_id', $request->user_id)
                ->whereBetween('solicituds.fecha_sol', [$request->fecha_i, $request->fecha_h])
                ->get();
        }


        return response(compact('ampliaciones'));
    }
}
