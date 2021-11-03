@extends('adminlte::page')

@section('title', 'Asign_Material')

@section('content_header')
    <style>
    #map {
        margin-top: 20px;
        width: 100%;
        height: 400px;
        position: absolute;
      }
    </style>
    <h1>Asignacion de Material
    @can('inspector')
    <a href="{{route('informes.autorizado')}}" class="btn btn-danger btn-rounded" style="float: right;">
        <i class="fa fa-arrow-circle-left"></i> Volver
    </a> </h1>
    @endcan

@stop

@section('content')
<div id="contenedor-tabla">


<div class="justify-content-center row">
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
                    <label for="informe">Dentro del Area de Concesión: </label> {{$informe->espesifiar_in}}
                    <div class="input-group ">
                    </div>
                </div>
                <div>
                    <label for="informe">Longitud de la Ampliación: </label> {{$informe->longitud_in}} metros
                    <div class="input-group ">
                    </div>
                </div>
                <div>
                    <label for="informe">Diametro de la Ampliación : </label> {{$informe->diametro_in}} metros
                    <div class="input-group ">
                    </div>
                </div>
                <div>
                    <label for="informe">Condiciones de Rasante: </label> {{$informe->condicion_rasante}}
                    <div class="input-group ">
                    </div>
                </div>
                {{-- <a type="button" class="btn btn-warning btn-icon w-100" title="Visualizar" onclick="visualizarMapa({{$informe->x_aprox}},{{$informe->y_aprox}}, '{{route('solicitud.obtenerAmpliaciones',$informe->solicitud_id)}}')">
                    <i class="fas fa-eye"></i> Visualizar Mapa</a> --}}
                <button type="button" class="btn btn-warning btn-icon w-100" onclick="visualizarMapa({{$informe->x_exact}},{{$informe->y_exact}}, '{{route('solicitud.obtenerAmpliaciones',$informe->solicitud_id)}}')" >
                    <i class="fas fa-eye"></i> Visualizar Mapa
                </button>


            </div>
          </div>
    </div>
    <!-- left column -->
    <div class="col-md-8" >
    <!-- general form elements -->
        <div class="card card-primary  h-100">
        <div class="card-header">
            <h3 class="card-title">ASIGNAR MATERIAL</h3>
        </div>
        <!-- /.card-header -->
        <!-- formulario inicio -->
        <form action="{{route('material_informe.store')}}" method="POST" role="form" id="form_materials">
            @csrf
            <div class="card-body">
                        <input type="hidden" name="id_informe" id="id_informe" value="{{$informe->id}}">

                <div class="form-group">
                    <label for="nombre_material">Descripcion Material</label>
                    <div class="input-group ">
                        <select class="form-control select2" onchange="cambiarMaterial()" name="id_material"  id="id_material" required>
                            <option value="0" selected>---Seleccione Material---</option>
                            @foreach ($materials as $material )
                                <option  value="{{$material->id}}-{{$material->precio_unitario}}">{{$material->nombre_material.' ('.$material->unidad_med.')'}}</option>
                            @endforeach
                        </select>

                        {{--  --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="cantidad">Cantidad de Material</label>
                        <div class="input-group col-md-12 ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                            </div>
                            <input type="number" min="1" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad de Material" required>
                        </div>

                    </div>
                    <div class="form-group col-6">
                        <label for="observador">Proveedor</label>
                        <div class="input-group" >
                            <div class="input-group-prepend">
                                <div >
                                    <p style="margin-right: 5px">Elapas
                                        <input type="radio" onchange="habilitarPrecio()" value ="Elapas" checked name="observador" style="margin-top:5px; margin-right: 3px">
                                    </p>
                                </div>
                            </div>
                            <div class="input-group-prepend">
                                <div >
                                    <p>Vecinos
                                        <input type="radio" onchange="habilitarPrecio()" value ="Vecinos" name="observador" style="margin-top:5px; margin-right: 3px">
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="cantidad">Precio Unitario</label>
                        <div class="input-group col-md-12 ">
                            <input type="number" min="0.00" step="0.01" name="precio" id="precio" class="form-control" placeholder="Precio unitario de Material" disabled required>
                        </div>
                        <input type="hidden" id="precio_elapas" name="precio_elapas">

                    </div>
                </div>
            </div>

            <!-- /.card-body -->
            <div class="card-footer " >
                <button type="submit" class="btn btn-block btn-primary ">Registrar</button>
            </div>
        </form>
        {{-- Fin de formulario --}}
        </div>
    </div>
</div>
<div class="table table-bordered table-hover dataTable table-responsive">
    <table class="table table-bordered datatable" id="example">
    <thead>
        <tr>
            <th width="170">ID</th>
            <th>MATERIAL</th>
            <th width="150">UNIDAD <br> MEDIDA</th>
            <th width="150">CANTIDAD <br> SOLICITADA </th>
            <th>PRECIO <br>UNITARIO</th>
            <th width="150">PROVEEDOR</th>
            <th width="150">ACCIONES</th>
        </tr>
    </thead>
    <tbody id="contenedor-materiales">
        @foreach ($mat_inf as $mat)
        <tr>
            <td>{{$mat->id}}</td>
            <td align="center">{{$mat->material_n}}</td>
            <td>{{$mat->unidad}}</td>
            <td>{{$mat->cantidad}}</td>
            <td>{{$mat->precio}}</td>
            <td>{{$mat->observador}}</td>
            <td>
                <form action="{{route('material_informe.eliminar', $mat->id)}}" method="POST">
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
    <div class="col-md-12">

        <div id="map">
        </div>
    </div>
</div>


@stop

@section('js')
    <script>
    $('.select2').select2();
    </script>
    <script src="{{asset('js/material_informe.js')}}"></script>
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
