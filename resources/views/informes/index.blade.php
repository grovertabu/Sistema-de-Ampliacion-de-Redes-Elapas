@extends('adminlte::page')

@section('title', 'Informes')
@php
    $n=1;
@endphp
@section('content_header')
@stop

@section('content')
    <h1>ELAPAS - Informes

        <a href="{{route('informes.autorizado')}}" class="btn btn-success btn-rounded float-md-right" >
           Informes Autorizados <i class="fa fa-plus-square"></i>
        </a>

        
    </h1>
    <div class="table table-bordered table-hover dataTable table-responsive">
        <table class="table table-bordered datatable" id="example">
        <thead>
          <tr>	
            <th>NRO</th>
            <th>NOMBRE SOLICITANTE</th>
            <th>FECHA <br>INSPECCION</th>
            <th>ESTADO</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($informes as $inf)
                <tr>
                    <td>{{$n++}}</td>
                    <td>{{$inf->nombre_sol}}</td>
                    <td>{{$inf->fecha_inspeccion}}</td>
                    <td align="center"><span class="badge badge-primary">{{strtoupper($inf->estado)}}</span></td>
                    <td>
                        @if ($inf->estado =='autorizado')
                            <button type="button" class='btn btn-warning btn-icon btn-xs' data-toggle="modal" data-target=".bd-example-modal-lg"ç
                            onclick="llamar('{{route('informes.show',$inf->id_informe)}}')">Material <i class="fas fa-box"></i></button>
                        @endif
                        
                        <a href='{{route('descargarPDF.informe',$inf->id_informe)}}' target="_blank" 
                        class='btn btn-danger btn-icon btn-xs'>Informe <i class="fas fa-file-pdf"></i></a>
                        @can('informes.edit')
                        <a href='{{route('informes.edit',$inf->id_informe)}}' 
                        class='btn btn-info btn-icon btn-xs'>Llenar <i class="fas fa-pencil-alt"></i></a>
                        @endcan
                        
                    </td>
                    
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>NRO</th>
                <th>NOMBRE SOLICITANTE</th>
                <th>FECHA <br>INSPECCION</th>
                <th>ESTADO</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>

    <!-- Large modal -->
                    

    <div class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow:hidden;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">LISTA DE MATERIALES</h5>
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

</div>

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
    
    </script>
    <script>
        function mimapa(x_aprox,y_aprox){
           var lati= x_aprox;
           var long= y_aprox;
             var coord= {lat:lati ,lng: long}
           var myOptions = {
                 zoom: 17,
                 center: coord,
                 mapTypeId: 'hybrid'
             };
          map = new google.maps.Map(document.getElementById('map'), myOptions);
          var marker = new google.maps.Marker({
              position:coord,
              map:map,
          });
       }

   </script>
@stop
@section('footer')
<strong>{{date("Y")}} || ELAPAS - SISTEMA DE AMPLIACION DE REDES DE AGUA </strong>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop