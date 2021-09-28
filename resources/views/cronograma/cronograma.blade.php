@extends('adminlte::page')

@section('title', 'Cronograma')
@php
    $dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
    $n=1;
@endphp
@section('content_header')
    {{$valor}}
    <div class="card">
        <h5 class="card-header">ELAPAS - CRONOGRAMA DE INSPECCIONES</h5>
        <div class="card-body">
          <h5 class="card-title"></h5>
          <form action="{{route('cronograma.reporte')}}" id="formCronograma" method="GET" class="form-inline">
            <div class="form-group mx-sm-3">
                <label for="nombre_material">Fecha de inspeccion :&nbsp;</label>
                <input type="date" name='fecha_i' id="fecha_i" class="form-control" >
            </div>
            <div class="form-group mx-sm-3">
                <label for="nombre_material">Nombre del Inspector :&nbsp;</label>
                    <select class="form-control  select2" name="user_id" id="user_id">
                        <option selected value="0">---Seleccione Inspector---</option>
                        @foreach ($inspectores as $inspector )
                            <option  value="{{$inspector->id}}">{{$inspector->name}}</option>
                        @endforeach
                    </select>
            </div>
            <button type="submit" class='btn btn-primary btn-icon'  id="cronograma">Buscar <i class="fas fa-search"></i></button>
         </form>
         
        </div>
      </div>
    @stop
@section('content')

<div class="card">
    <h5 class="card-header">ELAPAS - CRONOGRAMA DE INSPECCIONES
        @if(!empty($cronogramas))
        <a href="{{route('descargarPDF.cronograma',[$fecha_inspeccion,$valor])}}" target="_blank" class="btn btn-danger btn-rounded" style="float: right; margin-right: 5px;">
        Exportar Reporte <i class="fas fa-file-pdf"></i></a>
        @else
            <div></div>
        @endif
    
    </h5>
    
    <div class="card-body">
        <div id="cronograma" class="table table-bordered table-hover dataTable table-responsive">
            @if(!empty($cronogramas))
            <table class="table table-bordered datatable" id="example">
                <thead>
                    <tr>	
                        <th>Nro</th>
                        <th>BARRIO</th>
                        <th>NOMBRE DEL SOLICITANTE</th>
                        <th>CELULAR</th>
                        <th>MIERCOLES</th>
                        <th>JUEVES</th>
                        <th>INSPECTOR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cronogramas as $cronograma)
                    <tr>
                        <td>{{$n++}}</td>
                        <td>{{$cronograma->zona}}</td>
                        <td>{{$cronograma->nombre_sol}}</td>
                        <td>{{$cronograma->celular}}</td>
                        @if($dias[(date('N', strtotime($cronograma->fecha_inspe)))]=="miércoles")
                            <td>{{$cronograma->fecha_inspe}}</td>
                            <td></td>
                        @elseif ($dias[(date('N', strtotime($cronograma->fecha_inspe)))]=="jueves")
                            <td></td>
                            <td>{{$cronograma->fecha_inspe}}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        <td>{{$cronograma->name}}</td>
                    </tr>
                    @endforeach
            
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nro</th>
                        <th>BARRIO</th>
                        <th>NOMBRE DEL SOLICITANTE</th>
                        <th>CELULAR</th>
                        <th>MIERCOLES</th>
                        <th>JUEVES</th>
                        <th>INSPECTOR</th>
                    </tr>
                </tfoot>
            </table>
            @else
                <div>Sin datos a mostrar</div>
            @endif
            
        </div>
    </div>
</div>
    


@stop
    
@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>


        $('.select2').select2();
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};
        
        // function llamar () {
        //     var fecha= $('#fecha_id').val();
        //     alert($fecha)
        //     // var ajax = new XMLHttpRequest();
        //     // ajax.onreadystatechange = function(){
        //     //     if (ajax.readyState==4 && ajax.status==200) {
        //     //         document.getElementById("contenido").innerHTML=ajax.responseText;
        //     //     }
        //     // };
        //     // ajax.open("GET",url,true);
        //     // ajax.send();		
        // }
        
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop