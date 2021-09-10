@extends('adminlte::page')

@section('title', 'Descargos')
@php
    $n=1;
@endphp
@section('content_header')
<div class="card">
    {{-- {{$valor}} --}}
    <h5 class="card-header">ELAPAS - Descargo de Materiales</h5>
    <div class="card-body">
      <h5 class="card-title"></h5>
      <form action="{{route('descargo.index')}}" method="GET" class="form-inline">
        <div class="form-group mx-sm-3">
            <label for="nombre_material">Fecha de descargo :&nbsp;</label>

            <input type="date" name='fecha_d' id="fecha_d"class="form-control">
        </div>
        <div class="form-group mx-sm-3">
            <label for="nombre_material">Nombre del Inspector :&nbsp;</label>
            @if(auth()->user()->tipo_user=='Inspector')
                @can('inspector')
                    <span>{{auth()->user()->name}}</span>
                    @if(auth()->user()->tipo_user=='Inspector')
                    <input type="hidden" name="user_id" id="user_id" value="{{auth()->user()->id}}">
                    @endif
                @endcan
            @else
                @can('jefe-red')
                <select class="form-control  select2" name="user_id" id="user_id">
                    <option selected value="0">---Seleccione Inspector---</option>
                    @foreach ($inspectores as $inspector )
                        <option  value="{{$inspector->id}}">{{$inspector->name}}</option>
                    @endforeach
                </select>    
                @endcan
            @endif
            
        </div>
        <button type="submit" class='btn btn-primary btn-icon'  id="descargo">Buscar <i class="fas fa-search"></i></button>
     </form>
     
    </div>
  </div>
@stop


@section('content')
<div class="card">
    {{-- <h5 class="card-header">ELAPAS - DEASCARGO DE MATERIALES
        @if(!empty($descargos))
        <a href="{{route('descargarPDF.cronograma',[$fecha_inspeccion,$valor])}}" target="_blank" class="btn btn-danger btn-rounded" style="float: right; margin-right: 5px;">
        Exportar Reporte <i class="fas fa-file-pdf"></i></a>
        @else
            <div></div>
        @endif
    
    </h5> --}}  
    <div class="card-body">
        <div id="descargos" class="table table-bordered table-hover dataTable table-responsive">
            <strong class="justify-content-center row">{{$fecha_descargo}}</strong>
            @if(!empty($descargos))
            <table class="table table-bordered datatable" id="example">
                <thead>
                    <tr>	
                        <th>Nro</th>
                        <th>BARRIO</th>
                        <th>NOMBRE <br> DEL SOLICITANTE</th>
                        <th>INSPECTOR</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($descargos as $descargo)
                    <tr>
                        <td>{{$n++}}</td>
                        <td>{{$descargo->zona}}</td>
                        <td>{{$descargo->nombre_sol}}</td>
                        <td>{{$descargo->name}}</td>
                        <td>
                            @can('jefe-red')
                            @if($descargo->estado=='firmado')
                                <button type="button" class='btn btn-warning btn-icon btn-xs' data-toggle="modal" data-target=".bd-example-modal-lg"
                                onclick="llamar('{{route('descargo.mostrar_aportes_v',[$descargo->id_informe,$fecha_descargo,$valor])}}')">Aporte vecinos <i class="fas fa-file-alt"></i></button>

                                <button type="button" class='btn btn-warning btn-icon btn-xs' data-toggle="modal" data-target=".computo_elapas"
                                onclick="llamar2('{{route('descargo.mostrar_computo_e',[$descargo->id_informe,$fecha_descargo,$valor])}}')">Computo Elapas&nbsp;<i class="fas fa-file-alt"></i></button>
                            @endif
                            @endcan
                        </td>
                    </tr>
                    @endforeach
            
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nro</th>
                        <th>BARRIO</th>
                        <th>NOMBRE <br> DEL SOLICITANTE</th>
                        <th>INSPECTOR</th>
                        <th>ACCIONES</th>
                    </tr>
                </tfoot>
            </table>
            @else
                <div>Sin datos a mostrar</div>
            @endif
            
        </div>
    </div>
</div>
    {{-- Aporte material vecinos --}}
    <div class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow:hidden;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Aporte material vecinos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="contenido" >
                      {{--  --}}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  </div>
            </div>
        </div>
    </div>
    {{--  --}}

      {{-- --}}
     <div class="modal fade computo_elapas" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow:hidden;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Computo de Metrica Elapas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contenido2" >

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    {{--  --}}
    
@stop
@section('footer')
<strong>{{date("Y")}} || ELAPAS - SISTEMA DE AMPLIACION DE REDES DE AGUA </strong>
@stop
@section('js')
    <script>
        $('.select2').select2();
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        function llamar (url) {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                if (ajax.readyState==4 && ajax.status==200) {
                    document.getElementById("contenido").innerHTML=ajax.responseText;
                }
            };
            ajax.open("GET",url,true);
            ajax.send();		
        }
        function llamar2 (url) {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                if (ajax.readyState==4 && ajax.status==200) {
                    document.getElementById("contenido2").innerHTML=ajax.responseText;
                }
            };
            ajax.open("GET",url,true);
            ajax.send();		
        }
    
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop