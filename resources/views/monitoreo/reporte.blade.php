@extends('adminlte::page')

@section('title', 'Reporte de Proyectos')

@section('content_header')
    <div class="row col-sm-12">
        <h1 class="col-sm-10">ELAPAS - GENERAR REPORTES</h1>
        <button style="display:none;" id="btnVolver" onclick="ocultarVolver()" class=" col-sm-2 btn btn-danger btn-icon"><i class="fas fa-arrow-circle-left"> Volver</i></button>
    </div>


@stop
@section('content')
<div class="card" id="formulario">
    <div class="card-body">
      <h5 class="card-title"></h5>
      <form action="{{route('PDF.generar_reporte_proyectista')}}" id="formReporteInversion" method="POST" class="form">
        @method("POST")
        @csrf
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="nombre_material">De :&nbsp;</label>
                <input type="date" name='fecha_i' id="fecha_i" value="2021-11-09" required class="form-control" >
            </div>
            <div class="form-group col-sm-6">
                <label for="nombre_material">Hasta :&nbsp;</label>
                <input type="date" name='fecha_h' id="fecha_h" value="2021-12-15" required class="form-control" >
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Materiales</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($materials as $mat)
                          <div>
                            <input class="form-group" name="material_check[]" type="checkbox"  value="{{$mat->id}}">
                            <label for="customCheckbox1" >{{$mat->nombre_material}}</label>
                          </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <button type="button" id="btnMateriales"  class="btn btn-secondary">Marcar Todo</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                    <div class="card card-secondary ">
                        <div class="card-header">
                            <h3 class="card-title">Mano de Obra</h3>
                        </div>
                        <div class="card-body">
                            @foreach ($mano_obras as $mano)
                            <div>
                                <input class="form-group" name="mano_obra_check[]" type="checkbox"  value="{{$mano->id}}">
                                <label for="customCheckbox1" >{{$mano->descripcion}}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <button type="button" id="btnManoObra"  class="btn btn-secondary">Marcar Todo</button>
                        </div>
                    </div>
            </div>
        </div>
        <button type="submit" id="btnGenerarReporte" class='btn btn-danger btn-icon' >Generar Informe <i class="fas fa-file-pdf"></i></button>

    </form>

    </div>
    <div  style="display:none;" class="card col-12" id=respuesta>
        <h2 align="center">Reporte Inversion</h2>
        <div id="div_materiales">
            <h3>Inversión Materiales</h3>
            <table width="100%" border=1 id="table_materiales">
                <tr>
                    <td width="3%"rowspan="2">N°</td>
                    <td align="center" width="27%"rowspan="2">Nombre Material</td>
                    <td align="center" width="15%" rowspan="2">Unidad</td>
                    <td align="center" width="15%" rowspan="2">Precio</td>
                    <td align="center" width="20%" colspan="2">Cantidad</td>
                    <td align="center" width="20%" colspan="2">Sub Total</td>
                </tr>
                <tr>
                    <td align="center" width="10%">Elapas</td>
                    <td align="center" width="10%">Vecinos</td>
                    <td align="center" width="10%">Elapas</td>
                    <td align="center" width="10%">Vecinos</td>
                </tr>
                <tbody id="tbody_materiales">

                </tbody>
                <tfoot>
                    <tr>
                        <td   rowspan="2" colspan="6" align="right"><b>TOTAL Bs.</b></td>
                        <td   align="center" id="total_elp_materiales"><b>0</b></td>
                        <td   align="center" id="total_vecinos_materiales"><b>0</b></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" id="costo_total_materiales"></td>
                    </tr>
                </tfoot>
            </table>

        </div>
        <br>
        <div id="div_mano_obras">
            <h3>Inversion Mano Obras</h3>
            <table width="100%" border=1 id="table_mano_obras">
                <tr>
                    <td width="3%"rowspan="2">N°</td>
                    <td align="center" width="27%"rowspan="2">Actividad</td>
                    <td align="center" width="15%" rowspan="2">Unidad</td>
                    <td align="center" width="15%" rowspan="2">Precio</td>
                    <td align="center" width="20%" colspan="2">Cantidad</td>
                    <td align="center" width="20%" colspan="2">Sub Total</td>
                </tr>
                <tr>
                    <td align="center" width="10%">Elapas</td>
                    <td align="center" width="10%">Vecinos</td>
                    <td align="center" width="10%">Elapas</td>
                    <td align="center" width="10%">Vecinos</td>
                </tr>
                <tbody id="tbody_mano_obras">

                </tbody>
                <tfoot>
                    <tr>
                        <td rowspan="2" colspan="6" align="right"><b>TOTAL Bs.</b></td>
                        <td  align="center" id="total_elp_mano_obras"><b>0</b></td>
                        <td  align="center" id="total_vecinos_mano_obras"><b>0</b></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center" id="costo_total_mano_obras"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="card" id="cardPDF">

</div>




@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="{{asset('js/generar_reporte.js')}}"></script>

@stop
