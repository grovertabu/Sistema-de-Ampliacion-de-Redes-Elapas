@extends('adminlte::page')

@section('title', 'Asign_Material')

@section('content_header')
<style>
    #map {
        margin-top: 20px;
        width: 80%;
        height: 400px;
        position: absolute;
      }
    </style>
<div class="row">
    <h1 class="col-md-10" id="txtActividad">Registro de Mano de Obra</h1>
    <div class="col-md-2">
        @can('inspector')
        <a href="{{route('informes.autorizado')}}" class="btn btn-danger btn-rounded" style="float: right;">
            <i class="fa fa-arrow-circle-left"></i> Volver
        </a>
        @endcan
    </div>

</div>
@stop

@section('content')
    <div id="contenedor-tabla">
    <!-- left column -->
    <div class="justify-content-center row" >
        <div class="col-md-4 ">
            <div class="card card-primary h-100">
                <div class="card-header">
                    INFORMACION DE LA AMPLIACION
                </div>
                <div class="card-body">

                    <div>
                        <label for="informe">Nombre del Solicitante</label>
                        <div class="input-group ">
                            <p >{{$informe->solicitud->nombre_sol}}</p>
                        </div>
                    </div>

                    <div>
                        <label for="informe">Zona</label>
                        <div class="input-group ">
                            <p >{{$informe->solicitud->zona_sol}}</p>
                        </div>
                    </div>
                    <div>
                        <label for="informe">Dentro del Area de Concesión: </label>
                        <div class="input-group ">
                            {{$informe->espesifiar_in}}
                        </div>
                    </div>
                    <div>
                        <label for="informe">Longitud de la Ampliación: </label>
                        <div class="input-group ">
                            {{$informe->longitud_in}} metros
                        </div>
                    </div>
                    <div>
                        <label for="informe">Diametro de la Ampliación : </label>
                        <div class="input-group ">
                            {{$informe->diametro_in}} metros
                        </div>
                    </div>
                    <div>
                        <label for="informe">Condiciones de Rasante: </label>
                        <div class="input-group ">
                            {{$informe->condicion_rasante}}
                        </div>
                    </div>
                    <br>
                    <br>
                    {{-- <a type="button" class="btn btn-warning btn-icon w-100" title="Visualizar" onclick="visualizarMapa({{$informe->x_aprox}},{{$informe->y_aprox}}, '{{route('solicitud.obtenerAmpliaciones',$informe->solicitud_id)}}')">
                        <i class="fas fa-eye"></i> Visualizar Mapa</a> --}}
                    <button type="button" class="btn btn-warning btn-icon w-100" onclick="visualizarMapa({{$informe->x_exact}},{{$informe->y_exact}}, '{{route('solicitud.obtenerAmpliaciones',$informe->solicitud_id)}}')" >
                        <i class="fas fa-eye"></i> Visualizar Mapa
                    </button>


                </div>
              </div>
        </div>
    <!-- general form elements -->
        <div class="card card-primary col-md-8 h-100">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">REGISTRO DE MANO DE OBRA</h3>
                </div>
                <div class="form-group col-sm-6">
                    <select class="form-control select2" onchange="habilitarForm(this.value)"; name="actividad_id" id="actividad_id">
                        <option selected value="0">---Seleccione Actividad---</option>
                        @foreach ($actividad as $act )
                            <option  value="{{$act->id}}-{{$act->unidad_medida}}-{{$act->precio_unitario}}">{{$act->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <!-- /.card-header -->
        <!-- formulario inicio -->
        <form action="{{route('mano_obra.store')}}" method="POST" role="form" id="form_actividad">
            @csrf
            <div class="card-body">
                <input type="hidden" name="id_ejecucion" value="{{$ejecucion->id}}">
                <input type="hidden" name="id_informe" value="{{$ejecucion->informe_id}}">
                <input type="hidden" name="id_actividad" id="id_actividad" value="">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="ancho">Ancho (mts.)</label>
                        <div class="input-group">
                            <input class="form-control" type="number" min="0.00" step="0.01" oninput="calcularVolumen()"  name="ancho" id="ancho" placeholder="Ancho" disabled>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="cantidad">Alto (mts.)</label>
                        <div class="input-group">
                            <input type="number" min="0.00" step="0.01" name="alto" id="alto" oninput="calcularVolumen()"   class="form-control" placeholder="Alto" disabled>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombre_material">Largo (mts.)</label>
                        <div class="input-group">
                            <input class="form-control" type="number" min="0.00" step="0.01" oninput="calcularVolumen()"  name="largo" id="largo" placeholder="Largo" disabled>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="cantidad">Unidad</label>
                        <div class="input-group">
                            <input type="text" name="unidad" id="unidad" onchange="calcularVolumen()" class="form-control" placeholder="Unidad de Medida"  disabled required>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="cantidad">Cantidad</label>
                        <div class="input-group">
                            <input type="number" min="0.00" step = "0.01" name="cantidad" onchange="calcularVolumen()" id="cantidad" class="form-control" placeholder="Cantidad de Material" required disabled>
                        </div>

                    </div>
                    <div class="form-group col-6">
                        <label for="cantidad">Precio Unitario</label>
                        <div class="input-group">
                            <input type="number" min="0.00" step="0.01" name="precio_uni" id="precio" class="form-control" placeholder="Precio Unitario del Material" required disabled>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="observador">Proveedor</label>
                        <div class="input-group" >
                            <div class="input-group-prepend">
                                <div >
                                    <p style="margin-right: 5px">Elapas
                                        <input type="radio" value ="Elapas" checked name="observador" style="margin-top:5px; margin-right: 3px">
                                    </p>
                                </div>
                            </div>
                            <div class="input-group-prepend">
                                <div >
                                    <p>Vecinos
                                        <input type="radio" value ="Vecinos" name="observador" style="margin-top:5px; margin-right: 3px">
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button id="btnRegistrar" type="submit" class="btn btn-block btn-primary" disabled>Registrar</button>
            </div>
        </form>
        {{-- Fin de formulario --}}
        </div>
    </div>




<div class="table table-bordered table-hover dataTable table-responsive">
    <table class="table table-bordered datatable" id="example">
    <thead>
        <tr>
            <th width="50">ID</th>
            <th width="150">DESCRIPCION</th>
            <th width="50">ALTO</th>
            <th width="50">ANCHO</th>
            <th width="50">LARGO</th>
            <th width="50">CANTIDAD</th>
            <th width="50">UNIDAD <br> MEDIDA</th>
            <th width="50">PRECIO <br> UNITARIO</th>
            <th width="50">PROVEEDDOR</th>
            <th width="50">ACCIONES</th>
        </tr>
    </thead>
    <tbody id="contenedor-materiales">
        @foreach ($mano_obra as $mat)
        <tr>
            <td>{{$mat->mano_obras_id}}</td>
            <td align="center">{{$mat->descripcion}}</td>
            <td>{{$mat->alto}}</td>
            <td>{{$mat->ancho}}</td>
            <td>{{$mat->largo}}</td>
            <td>{{$mat->cantidad}}</td>
            <td>{{$mat->unidad}}</td>
            <td>{{$mat->precio_uni}}</td>
            <td>{{$mat->observador}}</td>
            <td>
                <form action="{{route('mano_obra.eliminar', $mat->mano_obras_id)}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-danger btn-icon btn-xs" type="submit">Eliminar  <i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach

        </tbody>
</table>
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
    </script>
    <script src="{{asset('js/mano_obra.js')}}"></script>
    <script src="{{asset('vendor/leaflet/js/leaflet.js')}}" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
    <script src="{{asset('vendor/leaflet/js/esri-leaflet.js')}}" integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ==" crossorigin=""></script>
    <script src="{{asset('vendor/leaflet/js/esri-leaflet-geocoder.js')}}" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
    <script src="{{asset('vendor/leaflet/js/easy-button.js')}}"></script>
    <script src="{{asset('js/mapas.js') }}"></script>

@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/leaflet.css')}}" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/esri-leaflet-geocoder.css')}}" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/easy-button.css')}}">
@stop
