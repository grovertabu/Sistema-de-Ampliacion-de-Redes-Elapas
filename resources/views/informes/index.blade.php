@extends('adminlte::page')

@section('title', 'Informes')
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
@stop

@section('content')
    <h1>ELAPAS - Informes


    </h1>
    <div class="table table-bordered table-hover dataTable table-responsive" id="contenedor-tabla">
        <table class="table table-bordered datatable" id="example">
        <thead>
          <tr>
            <th>NRO</th>
            <th>NOMBRE SOLICITANTE</th>
            <th>FECHA <br>INSPECCION</th>
            <th>CALLE</th>
            <th>ZONA</th>
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
                    <td>{{$inf->calle_sol}}</td>
                    <td>{{$inf->zona_sol}}</td>
                    <td align="center"><span class="badge badge-primary">{{strtoupper($inf->estado)}}</span></td>
                    <td>
                        <a type="button" class="d-inline btn btn-warning btn-icon" title="visualizar" onclick="visualizarMapa({{$inf->x_aprox}},{{$inf->y_aprox}}, {{$inf->id_solicitud}})">
                            <i class="fas fa-eye"></i></a>
                        @if ($inf->estado =='autorizado')
                            <button type="button" class='btn btn-warning btn-icon btn-xs' data-toggle="modal" data-target=".bd-example-modal-lg"ç
                            onclick="llamar('{{route('informes.show',$inf->id_informe)}}')" title="Material" ><i class="fas fa-box"></i></button>
                        @endif

                        <a href='{{route('descargarPDF.informe',$inf->id_informe)}}' target="_blank"
                        class='btn btn-danger btn-icon' title="Informe"><i class="fas fa-file-pdf"></i></a>
                        @if($inf->estado=='registrado')
                        @can('inspector')
                        {{-- <a href='{{route('informes.edit',$inf->id_informe)}}'
                        class='d-inline btn btn-primary btn-icon btn-xs'>Editar <i class="fas fa-pencil-alt"></i></a> --}}
                        @endcan
                        @else
                        @can('informes.edit')
                        <a href='{{route('informes.edit',$inf->id_informe)}}'
                            class='btn btn-info btn-icon ' title="Llenar"><i class="fas fa-pencil-alt"></i></a>
                        @endcan
                        @endif

                    </td>

                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>NRO</th>
                <th>NOMBRE SOLICITANTE</th>
                <th>FECHA <br>INSPECCION</th>
                <th>CALLE</th>
                <th>ZONA</th>
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

<div id="contenedor-mapa" style="display: none">
    <input type="hidden" id="obtenerAmpliaciones" >

    <button onclick="mostrarTabla(false)" class="btn btn-primary"> <i class="fas fa-arrow-circle-left"></i> Volver </button>

    <div id="map">
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
    function visualizarMapa(lat, long, ruta){
    mostrarTabla(true);
    document.querySelector('#obtenerAmpliaciones').value = 'solicitud/'+ ruta +'/obtener_ampliacion';
    ruta== null ? initMap(lat,long,'mostrar'):initMap(lat,long);
    }
   </script>
   <script src="{{asset('vendor/leaflet/js/leaflet.js')}}" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
   <script src="{{asset('vendor/leaflet/js/esri-leaflet.js')}}" integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ==" crossorigin=""></script>
   <script src="{{asset('vendor/leaflet/js/esri-leaflet-geocoder.js')}}" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
   <script src="{{asset('vendor/leaflet/js/easy-button.js')}}"></script>
   <script src="{{asset('js/mapas.js') }}"></script>

@stop
@section('footer')
<strong>{{date("Y")}} || ELAPAS - SISTEMA DE AMPLIACION DE REDES DE AGUA </strong>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/leaflet.css')}}" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/esri-leaflet-geocoder.css')}}" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/easy-button.css')}}">
@stop
