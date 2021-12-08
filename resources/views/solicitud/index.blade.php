@extends('adminlte::page')

@section('title', 'Solicitud')

@section('content_header')
  <style>
   #map {
      margin-top: 20px;
      width: 100%;
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
                    <td>{{$sol->id}}</td>
                    <td>{{$sol->nombre_sol}}</td>
                    <td>{{$sol->celular_sol}}</td>
                    <td>{{$sol->zona_sol}}</td>
                    <td>{{$sol->calle_sol}}</td>
                    <td>{{$sol->estado_sol}}</td>
                    <td>
                        <a type="button" class="d-inline btn btn-warning btn-icon" data-toggle="modal" data-target=".bd-example-modal-lg" onclick="visualizarMapa({{$sol->x_aprox}},{{$sol->y_aprox}}, {{$sol->id}})" title="Visualizar" id="btn_mostrar_mapa" >
                            <i class="fas fa-eye"></i></a>
                        @if($sol->estado_sol!='rechazado')

                        @can('solicitud.edit')
                        <a type="button" href='{{route('solicitud.edit',$sol)}}'
                        class='d-inline btn btn-info btn-icon'title="Editar"><i class="fas fa-pencil-alt"></i></a>
                        @endcan
                        @can('jefe-red')
                        <a type="button" href='{{route('solicitud.aprobar',$sol)}}'
                        class='d-inline btn btn-success btn-icon boton-aprobar'title="Aprobar"><i class="fas fa-check"></i></a>
                        @endcan
                        @can('jefe-red')
                        <a type="button" data-toggle="modal" data-toggle="modal" data-target="#exampleModal" onclick="modalObservaciones({{$sol->id }})"
                        class='d-inline btn btn-danger btn-icon' title="Rechazar"><i class="fas fa-times"></i></a>
                        @endcan
                        @can('solicitud.delete')
                        <form action="{{route('solicitud.destroy',$sol)}}" class="d-inline elimina" method="POST">
                            @csrf
                            @method('delete')
                            <button class='btn btn-danger btn-icon' title="Eliminar" type="submit"><i class="fas fa-trash"></i></button>
                        </form>
                        @endcan
                        @else
                        <a href='{{route('solicitud.PDFrechazado',$sol)}}' type="button" target='_blank'
                            class='d-inline btn btn-danger btn-icon' title="Reporte"><i class="fas fa-file"></i></a>
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
    <div class="col-md-12">
        <div id="map">
        </div>

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





@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset('vendor/leaflet/js/leaflet.js')}}" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/esri-leaflet.js')}}" integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/esri-leaflet-geocoder.js')}}" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/easy-button.js')}}"></script>

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
    <script src="{{asset('js/solicitud.js')}}"></script>

@stop
@section('footer')
<strong>{{date("Y")}} || ELAPAS - SISTEMA DE AMPLIACION DE REDES DE AGUA </strong>
@stop
@section('css')
<link rel="stylesheet" href="{{asset('vendor/leaflet/css/leaflet.css')}}" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<link rel="stylesheet" href="{{asset('vendor/leaflet/css/esri-leaflet-geocoder.css')}}" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
<link rel="stylesheet" href="{{asset('vendor/leaflet/css/easy-button.css')}}">
@stop
