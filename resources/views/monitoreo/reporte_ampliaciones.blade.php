@extends('adminlte::page')

@section('title', 'Reporte')
@section('css')
<style>
    .tabla_reporte{
        border: 1px solid black;
        border-collapse: collapse;
      }

</style>
@stop


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
                <input type="date" name='fecha_i' id="fecha_i" required class="form-control" >
            </div>
            <div class="form-group col-sm-6">
                <label for="nombre_material">Hasta :&nbsp;</label>
                <input type="date" name='fecha_h' id="fecha_h" required class="form-control" >
            </div>
        </div>

        <button type="submit" id="btnGenerarReporte" class='btn btn-danger btn-icon' >Generar Informe <i class="fas fa-file-pdf"></i></button>

    </form>

    </div>

</div>






@stop
@section('js')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="{{asset('js/informes.js')}}"></script>


@stop

