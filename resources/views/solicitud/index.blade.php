@extends('adminlte::page')

@section('title', 'Solicitud')
@php
    $n=1;
@endphp
@section('content_header')
  <style>
   #map {
      margin-top: 20px; 
      width: 80%;
      height: 400px;
      position: absolute;
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

    <div class="table table-bordered table-hover dataTable table-responsive" id="contenedor-tabla">
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
                        <a type="button" class="d-inline btn btn-warning btn-icon btn-xs" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="visualizarMapa({{$sol->x_aprox}},{{$sol->y_aprox}}, {{$sol->id}})" id="btn_mostrar_mapa" >
                            Visualizar <i class="fas fa-eye"></i></a>
                        @if($sol->estado_sol!='rechazado')
                            
                        @can('solicitud.edit')
                        <a href='{{route('solicitud.edit',$sol)}}' 
                        class='d-inline btn btn-info btn-icon btn-xs'>Editar <i class="fas fa-pencil-alt"></i></a>
                        @endcan
                        @can('jefe-red')
                        <br>
                        <a href='{{route('solicitud.aprobar',$sol)}}' 
                        class='d-inline btn btn-success btn-icon btn-xs boton-aprobar'>Aprobar <i class="fas fa-check"></i></a>
                        @endcan
                        @can('jefe-red')
                        <br>
                        <a type="button" data-toggle="modal" data-toggle="modal" data-target="#exampleModal" onclick="modalObservaciones({{$sol->id }})"
                        class='d-inline btn btn-danger btn-icon btn-xs'>Rechazar <i class="fas fa-times"></i></a>
                        @endcan 
                        @can('solicitud.delete')       
                        <form action="{{route('solicitud.destroy',$sol)}}" class="d-inline elimina" method="POST">
                            @csrf
                            @method('delete')
                            <button class='btn btn-danger btn-icon btn-xs' type="submit">Eliminar  <i class="fas fa-trash"></i></button>
                        </form>
                        @endcan
                        @else
                        <br>
                        <a href='{{route('solicitud.PDFrechazado',$sol)}}' target='_blank'
                            class='d-inline btn btn-danger btn-icon btn-xs'>Reporte <i class="fas fa-file"></i></a>  
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
  <div id="contenedor-mapa" style="display: none">
    <input type="hidden" id="obtenerAmpliaciones" >

    <button onclick="mostrarTabla(false)" class="btn btn-primary"> <i class="fas fa-arrow-circle-left"></i> Volver </button>

    <div id="map">
    </div>
  </div>

{{-- Modal para el registrar coordenadas --}}
{{-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">


    </div>

  </div>
</div> --}}

{{-- Modal fin --}}

@can('jefe-red')
{{-- Modal para el registrar coordenadas --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Observaciones (opcional)</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  id="formObservaciones" method="post">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="observaciones" id="observaciones" rows="3"></textarea>
                <input type="hidden"  id="id_ruta" name="id_ruta">
            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit"  class="btn btn-danger">Rechazar</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  @endcan
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
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script src="https://unpkg.com/esri-leaflet@2.3.2/dist/esri-leaflet.js" integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ==" crossorigin=""></script>
<script src="https://unpkg.com/esri-leaflet-geocoder@2.3.2/dist/esri-leaflet-geocoder.js" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>  

    @if(session('eliminar')=='Ok')
    <script>
        Swal.fire(
            'Eliminado!',
            'Su registro ha sido eliminado.',
            'success'
            )
    </script>
    @endif
    //Mensaje solicitud aprobada
    @if(session('aprobar')=='Ok')
    <script>
        Swal.fire(
            'Aprobado!',
            'La solicitud ha sido aprobada.',
            'success'
            )
    </script>
    @endif
    <script src="{{asset('js/mapas.js') }}"></script>
    <script>
         //function mimapa(x_aprox,y_aprox){
          //cargarMapa();
/*             var lati= x_aprox;
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
           }); */

          //}
           

        function modalObservaciones(ruta){
            document.querySelector('#id_ruta').value = 'solicitud/'+ ruta +'/rechazar'; 
            document.querySelector('#observaciones').value = "";
        }
        function visualizarMapa(lat, long, ruta){
            mostrarTabla(true);
            document.querySelector('#obtenerAmpliaciones').value = 'solicitud/'+ ruta +'/obtener_ampliacion';
            initMap(lat,long,ruta);
        }
        // manda form observaciones 
        document.querySelector('#formObservaciones').addEventListener('submit', (e)=>{
        e.preventDefault();
        var formData = new FormData(e.target);
        
        $.ajax({
                url: document.querySelector('#id_ruta').value,
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                      window.location.reload();
                }
        });
        });
        // aprobar solicitud
        document.querySelector('.boton-aprobar').addEventListener('click', (e)=>{
          e.preventDefault();
          Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea aprobar esta solicitud?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aprobar',
            cancelButtonText: 'cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location= e.target.href;
            }
          });
        });

    </script>
    <script>

</script>
@stop
@section('footer')
<strong>{{date("Y")}} || ELAPAS - SISTEMA DE AMPLIACION DE REDES DE AGUA </strong>
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.2/dist/esri-leaflet-geocoder.css" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
@stop