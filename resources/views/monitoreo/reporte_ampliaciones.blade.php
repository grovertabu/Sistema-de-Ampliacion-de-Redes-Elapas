@extends('adminlte::page')

@section('title', 'Reporte')
@section('css')
<style>
    .tabla_reporte{
        border: 1px solid black;
        border-collapse: collapse;
      }
    tr td {
        border: 1px solid black;
        border-collapse: collapse;
    }

</style>
@stop


@section('content_header')
    <div class="row col-sm-12">
        <h1 class="col-sm-10">ELAPAS - GENERAR REPORTES DE AMPLIACIONES</h1>
        <button style="display:none;" id="btnVolver" onclick="ocultarVolver()" class=" col-sm-2 btn btn-danger btn-icon"><i class="fas fa-arrow-circle-left"> Volver</i></button>
    </div>



@stop
@section('content')
<div class="card" id="formulario">
    <div class="card-body">
      <h5 class="card-title"></h5>
      <form action="{{route('PDF.generar_reporte_ampliacion')}}" id="formReporteAmpliaciones" method="POST" class="form">
        @method("POST")
        @csrf
        <div class="row">
            <div class="form-group col-sm-3">
                <label for="nombre_material">De :&nbsp;</label>
                <input type="date" name='fecha_i' id="fecha_i" required class="form-control" >
            </div>
            <div class="form-group col-sm-3">
                <label for="nombre_material">Hasta :&nbsp;</label>
                <input type="date" name='fecha_h' id="fecha_h" required class="form-control" value="{{date('Y').'-'.date('m').'-'.date('d')}}">
            </div>
            <div class="form-group mx-sm-3">
                <label for="nombre_material">Nombre del Inspector :&nbsp;</label>
                    <select class="form-control  select2" name="user_id" id="user_id">
                        <option selected value="0">Todos los Inspectores</option>
                        @foreach ($inspectores as $inspector )
                            <option  value="{{$inspector->id_inspector}}">{{$inspector->nombre_inspector}}</option>
                        @endforeach
                    </select>
            </div>
            <button type="submit" id="btnGenerarReporte" class='mt-4 h-25 btn btn-danger btn-icon' >Generar Informe </button>
        </div>


    </form>

    </div>
    <div id="tabla_respuesta" class="m-3" style="display:none;">
                <h3 >Informe de Ampliaciones
                    <button class="btn btn-danger ml-2" style="float:right;" onclick="convertirPDF()">
                        Imprimir <i class="fas fa-print"></i>
                    </button>
                    <button class="btn btn-success" style="float:right;" onclick="exportTableToExcel()">
                        Exportar a CSV  <i class="fas fa-file-csv"></i>
                    </button>
                </h3>
        <div class="mt-2" id="reporte_contenido">
            <h3 id="titulo_reporte" class="mt-1" align="center"></h3>
            <table class="tabla_reporte" style="border: 1px solid black; border-collapse: collapse;" id="tbl_contenido">
                <thead>
                    <tr>
                        <td style="border: 1px solid black; border-collapse: collapse;">Código</td>
                        <td style="border: 1px solid black; border-collapse: collapse;">Solicitante</td>
                        <td style="border: 1px solid black; border-collapse: collapse;">Zona</td>
                        <td style="border: 1px solid black; border-collapse: collapse;">Fecha Inspeccíon</td>
                        <td style="border: 1px solid black; border-collapse: collapse;">Inspector</td>
                        <td style="border: 1px solid black; border-collapse: collapse;">Fecha Autorización</td>
                        <td style="border: 1px solid black; border-collapse: collapse;">Fecha de Visto Bueno</td>
                        <td style="border: 1px solid black; border-collapse: collapse;">Fecha de Ejecución</td>
                        <td style="border: 1px solid black; border-collapse: collapse;">Estado</td>
                        <td style="border: 1px solid black; border-collapse: collapse;">Metros Ampliados</td>
                    </tr>
                </thead>
                <tbody id="contenido_tabla">
                </tbody>
            </table>
        </div>

    </div>
</div>






@stop
@section('js')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset('js/informes.js')}}"></script>
<script src="{{asset('js/reporte_ampliaciones.js')}}"></script>


@stop

