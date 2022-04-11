@extends('adminlte::page')

@section('title', 'Autorizacio')
@section('content_header')
<style>

    #map {
        margin-top: 20px;
        width: 100%;
        height: 400px;
      }
</style>
@stop

@section('content')
    <h1>ELAPAS - Informes Autorizados
        {{-- @can('informes.create')
        <a href="{{route('informes.create')}}" class="btn btn-success btn-rounded float-md-right" >
            Registrar Informe <i class="fa fa-plus-square"></i>
        </a>
        @endcan --}}

    </h1>
    <div class="table table-bordered table-hover dataTable table-responsive" id="contenedor-tabla">
        <table class="table table-bordered datatable" id="example">
        <thead>
          <tr>
            <th>NRO</th>
            <th>ZONA O BARRIO</th>
            <th>NOMBRE SOLICITANTE</th>
            <th>FECHA DE EJECUCION PROGRAMADA</th>
            <th>ESTADO</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
            @php
                $num = 1;
            @endphp
            @foreach ($informes as $inf)
                <tr>
                    <td>{{'S-'.$inf->id_solicitud}}</td>
                    <td>{{$inf->zona_sol}}</td>
                    <td>{{$inf->nombre_sol}}</td>
                    <td>
                        {{$inf->fecha_programada}}
                    </td>
                    <td align="center"><span class="badge badge-primary">{{strtoupper($inf->estado)}}</span></td>
                    <td width="200px">
                            <a type="button" class="w-25 d-inline btn btn-warning btn-icon" title="Visualizar" onclick="visualizarMapa({{$inf->x_exact}},{{$inf->y_exact}}, '{{route('solicitud.obtenerAmpliaciones',$inf->id_solicitud)}}')">
                                <i class="fas fa-eye"></i></a>

                            @can('inspector')
                            @if($inf->estado=='autorizado' || $inf->estado=='ejecutandose')
                            <button type="button" class='w-25 btn btn-warning btn-icon ' data-toggle="modal" data-target=".bd-example-modal-lg"
                            onclick="llamar('{{route('informes.show',$inf->id_informe)}}','material')" title="Material"><i class="fas fa-box"></i></button>
                            <button type="button" onclick="llamar('{{route('mano_obra.show',$inf->id_ejecucion)}}','mano_obra')" data-toggle="modal" data-target="#modal_mano_obra"
                                class='w-25 btn btn-warning btn-icon' title="Registrar Mano de Obra" ><i class="fas fa-hammer"></i></button>
                            @endif
                            @endcan



                            <button type="button" class="btn btn-primary btn-icon" title="Informes" data-toggle="modal" data-target="#exampleModal{{$num}}">
                            <i class="fa fa-file"></i>
                            </button>

                            <div class="modal fade" id="exampleModal{{$num}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Informes</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div style="text-align: center;" >
                                                @can('jefe-red')
                                                <p>
                                                    <a type="button" onclick="mostrarPDF('{{route('solicitud.escaneada',$inf->id_solicitud)}}')"  class=" text-white btn btn-danger btn-icon w-75">
                                                    Solicitud Escaneada <i class="fa fa-file-pdf"></i>
                                                    </a>
                                                </p>
                                                @endcan
                                                <p >
                                                    <a  onclick="mostrarPDF('{{route('descargarPDF.informe',$inf->id_informe)}}')" target="_blank"
                                                        class='text-white btn btn-danger btn-icon w-75'>Informe de Inspección <i class="fas fa-file-pdf"></i></a>
                                                </p>
                                                @can('inspector')
                                                    @if ($inf->estado == "firmado")
                                                        <p>
                                                            <a onclick="mostrarPDF('{{route('pedidoPDF.informe',$inf->id_informe)}}')" target="_blank"
                                                            class='text-white btn btn-danger btn-icon w-75'>Pedido de Material <i class="fas fa-file-pdf"></i></a>
                                                        </p>
                                                    @endif
                                                @endcan
                                                @can('jefe-red')
                                                    <p>
                                                        <a onclick="mostrarPDF('{{route('pedidoPDF.informe',$inf->id_informe)}}')" target="_blank"
                                                        class='text-white btn btn-danger btn-icon w-75'>Pedido de Material <i class="fas fa-file-pdf"></i></a>
                                                    </p>
                                                @endcan
                                                <p>
                                                    <a onclick="mostrarPDF('{{route('reportePDF.informe_material',$inf->id_informe)}}')" target="_blank"
                                                        class='text-white btn btn-danger btn-icon w-75'>Informe Ampliacion <i class="fas fa-file-pdf"></i></a>
                                                </p>
                                                {{-- @if($inf->fecha_ejecutada != null)
                                                    <p>
                                                        <a href='{{route('reportePDF.informe_descargo_material',$inf->id_informe)}}' target="_blank"
                                                            class='btn btn-danger btn-icon w-75'>Informe Descargo Material<i class="fas fa-box-open"></i></a>

                                                    </p>

                                                    reportePDF.informe_material',$inf->id_informe
                                                @endif --}}
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            @can('jefe-red')
                            @if($inf->estado=='autorizado')
                                <a href='{{route('informes.firmar',$inf->id_informe)}}'
                                class='btn btn-success btn-icon ' title="firmar"><i class="fas fa-pencil-alt"></i></a>
                            @endif
                            @endcan


                    </td>

                </tr>
                @php
                    $num++;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>NRO</th>
                <th>ZONA O BARRIO</th>
                <th>NOMBRE SOLICITANTE</th>
                <th>FECHA DE EJECUCION PROGRAMADA</th>
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
    <div class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_mano_obra" style="overflow:hidden;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ACTIVIDADES DE MANO DE OBRA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="contenido_mano_obra" >
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
    <div class="col-md-12">
        <div id="map">
        </div>
    </div>
</div>
@stop

@section('js')
    <script>
        $('.select2').select2();
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        function llamar (url, opcion) {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                if (ajax.readyState==4 && ajax.status==200) {
                    if(opcion == 'material')
                        document.getElementById("contenido").innerHTML=ajax.responseText;
                    else{
                        document.getElementById("contenido_mano_obra").innerHTML=ajax.responseText;
                    }
                }
            };
            ajax.open("GET",url,true);
            ajax.send();
        }
    function visualizarMapa(lat, long, ruta){
    mostrarTabla(true);
    document.querySelector('#obtenerAmpliaciones').value = ruta ;
    ruta== null ? initMap(lat,long,'mostrar'):initMap(lat,long);
    }
    </script>
    <script src="{{asset('vendor/leaflet/js/leaflet.js')}}" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <script src="{{asset('vendor/leaflet/js/esri-leaflet.js')}}" integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ==" crossorigin=""></script>
    <script src="{{asset('vendor/leaflet/js/esri-leaflet-geocoder.js')}}" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
    <script src="{{asset('vendor/leaflet/js/easy-button.js')}}"></script>
    <script src="{{asset('js/mapas.js') }}"></script>
    <script src="{{asset('js/informes.js') }}"></script>
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/leaflet.css')}}"  crossorigin="" />
        <link rel="stylesheet" href="{{asset('vendor/leaflet/css/esri-leaflet-geocoder.css')}}" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/easy-button.css')}}">
    <style>
        @media print {
            @page { margin: 0; }
            body { margin: 1.6cm; }
        }
    </style>
@stop
