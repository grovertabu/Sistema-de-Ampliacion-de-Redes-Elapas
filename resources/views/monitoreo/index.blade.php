@extends('adminlte::page')

@section('title', 'Monitoreo y Proyectos')
@php
    $dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
    $fecha="12-05-2021";
    $dia = $dias[(date('N', strtotime($fecha)))];
    $n = 0;
@endphp
@section('content_header')
  <style>
  #map {
    margin-top: 20px;
      width: 100%;
      height: 500px;
      position: absolute;
    }
  </style>
            <h1>ELAPAS - LISTADO DE SOLICITUDES
            @can("Monitor")
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
        @foreach ($solicitudall as $sol)
        @php
            $n++;
        @endphp

        <tr>
            <td>{{'S-'.$sol->solicitud_id}}</td>
            <td>{{$sol->nombre_sol}}</td>
            <td>{{$sol->celular_sol}}</td>
            <td>{{$sol->zona_sol}}</td>
            <td>{{$sol->calle_sol}}</td>
            <td align="center"><span class="badge badge-primary">{{$sol->estado_in == null ? strtoupper($sol->estado_sol): strtoupper($sol->estado_in)}}</span></td>
            <td width="200px">
                <a type="button" class="d-inline btn btn-warning btn-icon" title="Visualizar" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="visualizarMapa({{$sol->x_aprox}},{{$sol->y_aprox}}, {{$sol->solicitud_id}})" id="btn_mostrar_mapa" >
                    <i class="fas fa-eye"></i></a>

                <a type="button" onclick="mostrarPDF('{{route('solicitud.escaneada',$sol->solicitud_id)}}')" title="Mostrar Solicitud" class=" text-white btn btn-danger d-line btn-icon">
                    <i class="fa fa-file-pdf"></i>
                </a>
                @can('Monitor')

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$n}}">
                    <i class="fa fa-file"></i>
                  </button>

                  <div class="modal fade" id="exampleModal{{$n}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Informes</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" style="text-align: center;">
                          @if($sol->estado_in == "inspeccionado" || $sol->estado_in == "autorizado" ||  $sol->estado_in == "firmado" || $sol->estado_in == "ejecutandose" || $sol->estado_in == "ejecutado" )
                            <p>
                                <a onclick="mostrarPDF('{{route('descargarPDF.informe',$sol->informe_id)}}')" target="_blank"
                                    class='text-white btn btn-danger btn-icon w-75'>Informe de Inspección <i class="fas fa-file-pdf"></i></a>
                            </p>
                          @endif
                            @if($sol->estado_in == "firmado" || $sol->estado_in == "ejecutandose" || $sol->estado_in == "ejecutado")
                            <p>
                                <a onclick="mostrarPDF('{{route('pedidoPDF.informe',$sol->informe_id)}}')" target="_blank"
                                class='text-white btn btn-danger btn-icon w-75'>Pedido de Material <i class="fas fa-file-pdf"></i></a>

                            </p>

                            @endif


                            @if($sol->estado_in  == 'ejecutado')
                            <p>
                                <a onclick="mostrarPDF('{{route('reportePDF.informe_descargo_material',$inf->informe_id)}}')" target="_blank"
                                    class='text-white btn btn-danger btn-icon w-75'>Informe de Ejecución de Proyecto<i class="fas fa-file-pdf"></i></a>

                            </p>
                            @endif
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                @endcan
                @can('Proyectista')
                <button type="button" class="d-inline btn btn-primary btn-icon" title="Informes" data-toggle="modal" data-target="#exampleModal{{$n}}">
                    <i class="fa fa-file"></i>
                    </button>
                <a type="button" href="{{$sol->ubicacion}}" target="_blank" class="d-inline btn btn-success btn-icon" title="Ubicación Geografica">
                    <i class="fas fa-map-marker-alt"></i>
                </a>

                    <div class="modal fade" id="exampleModal{{$n}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <p>
                                            <a onclick="mostrarPDF('{{route('reportePDF.informe_material',$sol->informe_id)}}')" target="_blank"
                                                class=' text-white btn btn-danger btn-icon w-75'>Informe Ampliacion <i class="fas fa-file-pdf"></i></a>
                                        </p>
                                        @if ($sol->estado_in =='ejecutandose' || $sol->estado_in =='ejecutado')
                                        <p>
                                            <a onclick="mostrarPDF('{{route('descargarPDF.proyecto',$sol->informe_id)}}')" target="_blank" class=" text-white btn btn-danger btn-icon w-75" title="Informe Proyeccion">
                                                Informe Proyección<i class="fas fa-file-pdf"></i></a>
                                        </p>
                                        @endif
                                        {{-- @if($inf->fecha_ejecutada != null)
                                            <p>
                                                <a href='{{route('reportePDF.informe_descargo_material',$inf->id_informe)}}' target="_blank"
                                                    class='btn btn-danger btn-icon w-75'>Informe Descargo Material<i class="fas fa-box-open"></i></a>

                                            </p>


                                        @endif --}}
                                </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      @if ($sol->estado_in =='firmado')

                      <a href="{{route('informes.aprobar_proyecto',$sol->informe_id)}}" class="btn btn-success btn-icon" title="Aprobar Proyecto">
                          <i class="fas fa-check"></i></a>
                      @endif
                @endcan
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

{{-- Visualizar Mapa--}}
<div id="contenedor-mapa" style="display: none">
    <input type="hidden" id="obtenerAmpliaciones" >
    <button onclick="mostrarTabla(false)" class="btn btn-primary"> <i class="fas fa-arrow-circle-left"></i> Volver </button>
    <div class="col-md-12">
        <div id="map">
        </div>

    </div>
  </div>

{{-- Fin Visualizar Mapa--}}



@stop
@section('js')
<script src="{{asset('vendor/leaflet/js/leaflet.js')}}" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/esri-leaflet.js')}}" integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/esri-leaflet-geocoder.js')}}" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/easy-button.js')}}"></script>
<script src="{{asset('js/mapas.js') }}"></script>
<script src="{{asset('js/informes.js') }}"></script>
<script>
    function visualizarMapa(lat, long, ruta){
    mostrarTabla(true);
    console.log('solicitud/'+ ruta +'/obtener_ampliacion')
    document.querySelector('#obtenerAmpliaciones').value = 'solicitud/'+ ruta +'/obtener_ampliacion';
    ruta== null ? initMap(lat,long,'mostrar'):initMap(lat,long);
    }
</script>

@stop
@section('css')
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/leaflet.css')}}" crossorigin="" />
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/esri-leaflet-geocoder.css')}}" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/easy-button.css')}}">
@stop
