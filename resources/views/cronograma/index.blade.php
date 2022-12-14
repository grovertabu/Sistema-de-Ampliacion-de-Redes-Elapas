@extends('adminlte::page')

@section('title', 'Cronograma')
@php
    $n=1;
    $dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
    $fecha="12-05-2021";
    $dia = $dias[(date('N', strtotime($fecha)))];
@endphp
@section('content_header')
  <style>
  #map {
      margin-top: 20px;
      width: 100%;
      height: 400px;
    }
  </style>
  @can('jefe-red')
  <h1>ELAPAS - CRONOGRAMA DE ASIGNACION
  </h1>
  <h2>{{date("d-m-Y")}}</h2>
  @endcan
  @can('Monitor')
  <h1>ELAPAS - LISTADO DE SOLICITUDES</h1>
  @endcan


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
          @can('jefe-red')
          @foreach ($solicitud as $sol)
          <tr>
              <td>{{$n++}}</td>
              <td>{{$sol->nombre_sol}}</td>
              <td>{{$sol->celular_sol}}</td>
              <td>{{$sol->zona_sol}}</td>
              <td>{{$sol->calle_sol}}</td>
              <td>{{$sol->estado_sol}}</td>
              <td>
                  <button type="button" class='btn btn-primary btn-icon' data-toggle="modal" data-target=".bd-example-modal-lg{{$sol->id}}"
                  onclick="" title="Asignar Inspector" ><i class="fas fa-user-check"></i></button>

                  <!-- Large modal -->
                  <div class="modal fade bd-example-modal-lg{{$sol->id}}" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow:hidden;">
                      <div class="modal-dialog modal-md">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Inspectores</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body" id="contenido" >
                                  <div class="justify-content-center row">
                                      <!-- left column -->
                                      <div class="col-md-12">
                                      <!-- general form elements -->
                                          <div class="card card-primary ">
                                          <div class="card-header">
                                              <h3 class="card-title">Asignar Inspector</h3>
                                          </div>
                                          <!-- /.card-header -->
                                          <!-- formulario inicio -->
                                          <form action="{{route('cronograma.store')}}" method="POST" role="form" id="form_materials">
                                              @csrf
                                              <div class="card-body">
                                                  <div class="form-group">
                                                      <label for="nombre_material">Solicitud</label>
                                                      <p class="form-control">{{$sol->nombre_sol}}</p>
                                                      <input type="hidden" name="solicitud_id" value="{{$sol->id}}">
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="nombre_material">Nombre del Inspector</label>
                                                      <select class="form-control  select2" name="user_id" id="user_id">
                                                          <option selected>---Seleccione Inspector---</option>
                                                          @foreach ($inspectores as $inspector )
                                                              <option  value="{{$inspector->id}}">{{$inspector->name}}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                                  <div class="form-group col-md-6">
                                                      <label for="fecha_inspe">Fecha de inspeccion</label>
                                                      <div class="input-group ">
                                                          <div class="input-group-prepend">
                                                          </div>
                                                          <input class="form-control" id="fecha_inspe" name="fecha_inspe" type="datetime-local" value="">
                                                      </div>
                                                  </div>
                                              </div>
                                              <!-- /.card-body -->
                                              <div class="card-footer">
                                                  <button type="submit" class="btn btn-block btn-primary">Asignar</button>
                                              </div>
                                          </form>
                                          {{-- Fin de formulario --}}
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                              </div>
                          </div>
                      </div>
                  </div>


                  <a type="button" class="d-inline btn btn-warning btn-icon" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="visualizarMapa({{$sol->x_aprox}},{{$sol->y_aprox}}, {{$sol->id}})" title="Visualizar" id="btn_mostrar_mapa" >
                    <i class="fas fa-eye"></i></a>
                  {{-- <a type="button" class="d-inline btn btn-warning btn-icon" title="Visualizar" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="mimapa({{$sol->x_aprox}},{{$sol->y_aprox}})" id="btn_mostrar_mapa">
                      <i class="fas fa-eye"></i></a> --}}
              </td>
          </tr>
      @endforeach
          @endcan

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
    <div class="col-md-12">
        <div id="map">
        </div>

    </div>
</div>

{{-- Modal para el registrar coordenadas --}}
{{-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="map" class="modal-content">

    </div>
  </div>
</div> --}}

{{-- Modal fin --}}

<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBUW9zimMRIYLdOBY4FrSyqd13IaJ7N4Y0">
</script>


@stop
@section('js')
<script src="{{asset('vendor/leaflet/js/leaflet.js')}}" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/esri-leaflet.js')}}" integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/esri-leaflet-geocoder.js')}}" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/easy-button.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {{-- <script>
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

        $('.select2').select2();
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};


    </script> --}}
    <script src="{{asset('js/mapas.js') }}"></script>
    <script src="{{asset('js/solicitud.js')}}"></script>
    <script src="{{asset('js/informes.js')}}"></script>
    <script src="{{asset('js/cronograma.js')}}"></script>
@stop
@section('css')
<link rel="stylesheet" href="{{asset('vendor/leaflet/css/leaflet.css')}}"  crossorigin="" />
<link rel="stylesheet" href="{{asset('vendor/leaflet/css/esri-leaflet-geocoder.css')}}" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
<link rel="stylesheet" href="{{asset('vendor/leaflet/css/easy-button.css')}}">
@stop
