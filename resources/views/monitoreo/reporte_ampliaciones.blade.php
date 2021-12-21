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
      <form action="{{route('PDF.generar_reporte_ampliacciones')}}" id="formReporteAmpliaciones" method="POST" class="form">
        @method("POST")
        @csrf
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="nombre_material">De :&nbsp;</label>
                <input type="date" name='fecha_i' id="fecha_i" required class="form-control" >
            </div>
            <div class="form-group col-sm-4">
                <label for="nombre_material">Hasta :&nbsp;</label>
                <input type="date" name='fecha_h' id="fecha_h" required class="form-control" >
            </div>
            <button type="submit" id="btnGenerarReporte" class='mt-4 h-25 btn btn-danger btn-icon' >Generar Informe </button>
        </div>


    </form>

    </div>
    <div id="tabla_respuesta" class="m-3">
        <div class="row">
            <div class="col-md-10">
                <h3 id="titulo_reporte">Informe de Ampliaciones</h3>
            </div>
            <div class="col-md-2">
                <button class="btn btn-danger">
                    Imprimir <i class="fas fa-print"></i>
                </button>

            </div>
        </div>
        <div class="mt-2" >
            <table class="tabla_reporte" width="100%">
                <thead>
                    <tr>
                        <td>Código</td>
                        <td>Solicitante</td>
                        <td>Zona</td>
                        <td>Fecha Inspeccíon</td>
                        <td>Inspector</td>
                        <td>Fecha Autorización</td>
                        <td>Fecha de Visto Bueno</td>
                        <td>Fecha de Ejecución</td>
                        <td>Estado</td>
                        <td>Metros de Ampliación</td>
                    </tr>
                </thead>
                <tbody id="contenido_tabla">
                    <tr>
                        <td>S-1</td>
                        <td>Carolina Herrera</td>
                        <td>Fancesa</td>
                        <td>17-12-2021</td>
                        <td>Patricio Condori</td>
                        <td>18-12-2021</td>
                        <td>18-12-2021</td>
                        <td>25-12-2021</td>
                        <td>EJECUTADO</td>
                        <td>98</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>






@stop
@section('js')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="{{asset('js/informes.js')}}"></script>
<script src="{{asset('js/reporte_ampliaciones.js')}}"></script>


@stop

