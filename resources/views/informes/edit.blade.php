@extends('adminlte::page')

@section('title', 'Llenar informe')

@section('content_header')
    <style>
   #map {
      margin-top: 20px;
      width: 100%;
      height: 400px;
      position: absolute;
    }
    </style>
    <h1>Informes de ampliacion de redes</h1>
@stop
@php
    $fecha_arreglada = str_replace(" ","T",$informe->fecha_hora_in);
@endphp

@section('content')
<div class="justify-content-center row" id="contenedor-tabla">
    <!-- left column -->
    <div class="col-md-8">
    <!-- general form elements -->
        <div class="card card-primary ">
        <div class="card-header">
            <h3 class="card-title">Registrar Informe</h3>
        </div>
        <!-- /.card-header -->
        <!-- formulario inicio -->
        <form action="{{route('informes.update',$informe)}}" method="POST" role="form" id="form_informes">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_sol">Solicitante</label>
                    <div class="input-group ">
                        <input type="hidden" name="solicitud_id" id="solicitud_id" value="{{$informe->solicitud_id}}">
                        <p class="form-control">{{$informe->solicitud->nombre_sol}}</p>

                        {{--  --}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-7">
                        <label for="fecha_hora_in">Fecha de inspección</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            </div>
                            <input class="form-control" id="fecha_hora_in" name="fecha_hora_in" type="datetime-local" value="{{$fecha_arreglada}}" id="example-datetime-local-input" required>
                        </div>

                    </div>
                    <div class="col-5"><br>
                        <label for="espesifiar">Dentro del area de concesión</label><br>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="espesifiar_in" id="inlineRadio1"
                            @if($informe->espesifiar_in != null && $informe->espesifiar_in == "Si") @php echo "checked" @endphp @endif value="Si" required> Si
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="espesifiar_in" id="inlineRadio2"
                            @if($informe->espesifiar_in != null && $informe->espesifiar_in == "No") @php echo "checked" @endphp @endif value="No" required> No
                            </label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="Ubicacion_georeferencial">Ubicación Georeferencial</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>

                                <input type="text" name="ubicacion_geo" id="ubicacion_geo" class="form-control" value="" placeholder="Ubicacion georeferencial" required>
                                {{--  --}}

                                {{--  --}}
                            </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label for="Latitud">Latitud</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                                <input type="text" name="x_exact" id="x_exact" class="form-control" oninput="mapLink()" placeholder="Indicar coordenada Lat" value="{{$informe->solicitud->x_aprox}}" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="Longitud">Longitud</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                                <input type="text" name="y_exact" id="y_exact" class="form-control" oninput="mapLink()" placeholder="Indicar Coordenada Lng" value="{{$informe->solicitud->y_aprox}}" required>
                        </div>
                    </div>
                    <div class="card-footer">

                        <button type="button" class="btn btn-block btn-outline-success" onclick="drawMapa(true)" {{-- data-toggle="modal" data-target=".bd-example-modal" --}}  >
                        Registrar Ampliación</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label for="longitud_in">Longitud de la Ampliación</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                                <input type="number" min="1" name="longitud_in" id="longitud_in" value="{{$informe->longitud_in}}" class="form-control" placeholder="Longitud" required>
                        <div class="input-group-prepend">
                            <span class="input-group-text">mts.</span>
                        </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="diametro_in">Diametro de la ampliación</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                                <input type="number" min="0.01" step="0.01" name="diametro_in" id="diametro_in" value="{{$informe->diametro_in}}" class="form-control" placeholder="Diametro" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text">mts.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="Longitud">Número de Beneficiarios</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                            </div>
                                <input type="number" min="1" name="num_ben_in" id="num_ben_in" value="{{$informe->num_ben_in}}" class="form-control" placeholder="Nº:...." required>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="Familia">Número de Familias Beneficiadas</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                            </div>
                                <input type="number" min="1" name="num_flia_in" id="num_flia_in" value="{{$informe->num_flia_in}}" class="form-control" placeholder="Flia::...." required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6"><br>
                        <label for="espesifiar">Condiciones de Rasante</label><br>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="condicion_rasante" id="inlineRadio1"
                            @if($informe->condicion_rasante != null && $informe->condicion_rasante == "BUENA") @php echo "checked" @endphp @endif value="BUENA" required> BUENA
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="condicion_rasante" id="inlineRadio2"
                            @if($informe->condicion_rasante != null && $informe->condicion_rasante == "MALA") @php echo "checked" @endphp @endif value="MALA" required> MALA
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="reservorio">Reservorio</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                            </div>
                                <input type="text" name="reservorio" id="reservorio" value="{{$informe->reservorio}}" class="form-control" placeholder="Nº:...." required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="reservorio">Imagen Vista Previa</label>
                        <div class="input-group ">
                            <img src="{{$informe->imagen_amp== null ?  asset('images/no-disponible.png'): asset('storage/'.$informe->imagen_amp)}}" width="650px" height="342px"alt="Vista Previa" id="imgMap">
                            <input type="hidden" name="textMap" id="textMap">
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-block btn-primary">Registrar</button>
            </div>
        </form>
        {{-- Fin de formulario --}}
        </div>
    </div>
</div>
{{-- Modal para el registrar coordenadas --}}
{{-- <div class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div id="map" class="modal-content">

      </div>
    </div>
  </div> --}}

  <div id="contenedor-mapa" style="display: none">
    <button onclick="mostrarTabla(false,true)" class="btn btn-primary"> <i class="fas fa-arrow-circle-left"></i> Volver </button>
    <button onclick="downloadMap()" class="btn btn-danger"> <i class="fas fa-save"></i> Guardar Imagen</button>
    <form action="{{route('solicitud.guardarAmpliacion',$informe->solicitud)}}" method="POST" id="formAmpliaciones">@csrf</form>
    <input type="hidden" id="obtenerAmpliaciones" value="{{route('solicitud.obtenerAmpliaciones',$informe->solicitud)}}" >
    <div class="col-md-12">
        <div  id="map">
        </div>

    </div>
  </div>
  {{-- Modal fin --}}

@stop



@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset('vendor/leaflet/js/leaflet.js')}}" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/esri-leaflet.js')}}" integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/esri-leaflet-geocoder.js')}}" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/easy-button.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="{{asset('js/html2canvas.min.js')}}"></script>
<script src="{{asset('js/leaflet_export.js')}}"></script>
<script src="{{asset('js/mapas.js')}}"></script>
    <script>
    $('.select2').select2();
    </script>
@if(session('crear')=='Ok')
<script>
    Swal.fire(
        'Eliminado!',
        'Su registro ha sido eliminado.',
        'success'
        )
</script>
@else
@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Algo salió mal!',
        })

    </script>
@endif
@endif
<script>
    let fechaInspeccion;
    document.addEventListener('DOMContentLoaded',()=>{
        calcularDistancia();
        mapLink()
        fechaInspeccion = document.querySelector('#fecha_hora_in').value;
        // document.querySelector('#map').style.width = window.screen.width ;
    });
    document.querySelector("#fecha_hora_in").addEventListener('change',()=>{
        document.querySelector("#fecha_hora_in").value = fechaInspeccion;
    })
</script>
<script>

    document.getElementById('form_informes').addEventListener('submit',(e)=>{
        e.preventDefault();
        let val;
        const imagen = document.getElementById('imgMap').src.split('/')[4];
        if(imagen === "no-disponible.png"){
            Swal.fire({
            icon: 'error',
            title: 'Imagen Requerida',
            text: 'Saque una captura del mapa',
            })
        }else {
        document.querySelector('#form_informes').submit();
        }
    })

</script>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/leaflet.css')}}" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/esri-leaflet-geocoder.css')}}" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/easy-button.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw-src.css"/>

@stop
