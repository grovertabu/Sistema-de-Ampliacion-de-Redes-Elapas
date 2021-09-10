@extends('adminlte::page')

@section('title', 'Solicitud')
@php
    $n=1;
@endphp
@section('content_header')
  <style>
  #map {
      height: 70%;
      padding: 40%;
    }
  </style>
    <h1>ELAPAS - Solicitud
        @can('solicitud.create')
        <a href="{{route('solicitud.create')}}" class="btn btn-success btn-rounded" style="float: right;">
            Registrar Solicitud <i class="fa fa-plus-square"></i>
        </a>
        @endcan
        @can('jefe-red')
        <a href="{{route('solicitud.reject')}}" class="btn btn-warning btn-rounded" style="float: right;">
            Solicitudes Rechazadas<i class="fa fa-delete"></i>
        </a>
        @endcan
    </h1>

@stop
@section('content')

    <div class="table table-bordered table-hover dataTable table-responsive">
        <table class="table table-bordered datatable" id="example">
        <thead>
          <tr>	
            <th>Nro</th>
            <th>Nombre solicitante</th>
            <th>Celular</th>
            <th>Zona</th>
            <th>Calle</th>
            <th>estado</th>
            <th width="120">Acciones</th>
          </tr>
        </thead>
        <tbody>
          
            @foreach ($solicitud as $sol)
                <tr>
                    <td>{{$n++}}</td>
                    <td>{{$sol->nombre_sol}}</td>
                    <td>{{$sol->celular_sol}}</td>
                    <td>{{$sol->zona_sol}}</td>
                    <td>{{$sol->calle_sol}}</td>
                    <td>{{$sol->estado_sol}}</td>
                    <td>
                        <a type="button" class="d-inline btn btn-warning btn-icon btn-xs" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="mimapa({{$sol->x_aprox}},{{$sol->y_aprox}})" id="btn_mostrar_mapa">
                            Visualizar <i class="fas fa-eye"></i></a>
                        @if($sol->estado_sol!='rechazado')
                            
                        @can('solicitud.edit')
                        <a href='{{route('solicitud.aprobar',$sol)}}' 
                        class='d-inline btn btn-info btn-icon btn-xs'>Editar <i class="fas fa-pencil-alt"></i></a>
                        @endcan
                        @can('jefe-red')
                        <a href='{{route('solicitud.aprobar',$sol)}}' 
                        class='d-inline btn btn-success btn-icon btn-xs'>Aprobar <i class="fas fa-pencil-alt"></i></a>
                        @endcan
                        @can('jefe-red')
                        <a href='{{route('solicitud.rechazar',$sol)}}' 
                        class='d-inline btn btn-danger btn-icon btn-xs'>Rechazar <i class="fas fa-pencil-alt"></i></a>
                        @endcan 
                        @can('solicitud.delete')       
                        <form action="{{route('solicitud.destroy',$sol)}}" class="d-inline elimina" method="POST">
                            @csrf
                            @method('delete')
                            <button class='btn btn-danger btn-icon btn-xs' type="submit">Eliminar  <i class="fas fa-trash"></i></button>
                        </form>
                        @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Nro</th>
                <th>Nombre solicitante</th>
                <th>Celular</th>
                <th>Zona</th>
                <th>Calle</th>
                <th>estado</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>
</div>

{{-- Modal para el registrar coordenadas --}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="map" class="modal-content">
      
    </div>
  </div>
</div>

{{-- Modal fin --}}

<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBUW9zimMRIYLdOBY4FrSyqd13IaJ7N4Y0">
</script>
    @can('users.index')
    {{-- <button type="button" class="btn btn-primary m-1" id="btnOpenSaltB">Open Sweetalert2 (Basic)</button>
    <button type="button" class="btn btn-success m-1" id="btnOpenSaltC">Open Sweetalert2 (Custom)</button> --}}
    @endcan
    
@stop
    
@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @if(session('eliminar')=='Ok')
    <script>
        Swal.fire(
            'Eliminado!',
            'Su registro ha sido eliminado.',
            'success'
            )
    </script>
    @endif
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