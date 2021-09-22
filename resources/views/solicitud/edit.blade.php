@extends('adminlte::page')

@section('title', 'Actualizar solicitud')

@section('content_header')
    <h1>ELAPAS</h1>
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
<div class="container-fluid">
    <div class="justify-content-center row" id="contenedor-tabla">
      <!-- left column -->
        <div class="col-md-6">
        <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Actualizar Solicitud</h3>
            </div>
            <!-- /.card-header -->
            <!-- formulario inicio -->
            <form action="{{route('solicitud.update',$solicitud)}}" method="post" role="form" id="form_solicitud">
                @csrf
                @method('put')
                <div class="card-body">
                <div class="form-group">
                    <label for="nombre_sol">Nombre del Solicitante</label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="nombre_sol" id="nombre_sol" class="form-control" placeholder="nombre del solicitante" value="{{$solicitud->nombre_sol}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="celular_sol">Celular</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text" name="celular_sol" id="celular_sol" class="form-control" placeholder="Celular" value="{{$solicitud->celular_sol}}">
                        </div>
                        
                    </div>
                    
                    <div class="col-6">
                        <label for="zona_sol">Zona</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" name="zona_sol" id="zona_sol" class="form-control" placeholder="Zona" value="{{$solicitud->zona_sol}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <label for="Calle">Calle</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" name="calle_sol" id="calle_sol" class="form-control" placeholder="Calle" value="{{$solicitud->calle_sol}}">
                        </div>
                        
                    </div>
                    
                    <div class="col-4">
                        <label for="exampleInputEmail1">fecha</label>
                        <input type="date" name="fecha_sol" id="fecha_sol" class="form-control" placeholder="Zona" value="{{$solicitud->fecha_sol}}">
                        <input type="hidden" name="estado_sol" id="estado_sol" value="{{$solicitud->estado_sol}}">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-6">
                        <label for="Calle">Latitud</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" name="x_aprox" id="x_aprox" class="form-control" placeholder="Latitud" value="{{$solicitud->x_aprox}}">
                        </div>
                        
                    </div>
                    
                    <div class="col-6">
                        <label for="exampleInputEmail1">Longitud</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" name="y_aprox" id="y_aprox" class="form-control" placeholder="Longitud" value="{{$solicitud->y_aprox}}">

                        </div>
                    </div>
                </div><br>
                <div class="card-footer">
                    <button type="button" class="btn btn-block btn-outline-success" onclick="editarMapa()">
                    Actualizar ubicacion aproximada</button>
                </div>
                {{-- Modal para el registrar coordenadas --}}
{{--                 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            {{-- contenio del mapa --}}
                       {{-- <h2>mi primer modal</h2>
                          {{-- fin del mapa --}}
                       {{-- </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button type="button" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                      </div>
                    </div>
                  </div> --}}
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                <button type="submit" class="btn btn-block btn-primary">Actualizar</button>
                </div>
            </form>
            {{-- Fin de formulario --}}
            </div>
        </div>
    </div>
    <div id="contenedor-mapa" style="display: none">
    
        <button onclick="mostrarTabla(false)" class="btn btn-primary"> <i class="fas fa-arrow-circle-left"></i> Volver </button>
    
        <div id="map">
        </div>
    </div>

</div>


@stop

@section('js')
<script>
function editarMapa(){
    const lat = document.getElementById('x_aprox').value;
    const long = document.getElementById('y_aprox').value;
    mostrarTabla(true);
    initEditMap(lat,long);
}
</script>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script src="https://unpkg.com/esri-leaflet@2.3.2/dist/esri-leaflet.js" integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ==" crossorigin=""></script>
<script src="https://unpkg.com/esri-leaflet-geocoder@2.3.2/dist/esri-leaflet-geocoder.js" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="{{asset('js/mapas.js')}}"></script>


@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.2/dist/esri-leaflet-geocoder.css" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw-src.css"/>
@stop