@extends('adminlte::page')

@section('title', 'Llenar informe')

@section('content_header')
    <style>
   #map {
      margin-top: 20px;
      width: 100%;
      height: 400px;

    }
    </style>
    <h1>Rechazar Solicitud</h1>
@stop
@php

@endphp

@section('content')
<div class="container">
    <div id="contenedor-mapa">
        <a type="button" href="{{route('solicitud.index')}}" class="btn btn-primary"> <i class="fas fa-arrow-circle-left"></i> Volver </a>
        <button onclick="downloadMap()" class="btn btn-danger"> <i class="fas fa-save"></i> Guardar Imagen</button>
        <form action="{{route('solicitud.guardarAmpliacion',$solicitud->id)}}" method="POST" id="formAmpliaciones">@csrf</form>
        <input type="hidden" id="obtenerAmpliaciones" value="{{route('solicitud.obtenerAmpliaciones',$solicitud->id)}}" >
        <div class="col-12">
            <div  id="map">
            </div>
        </div>
      </div>
      <div class="card">
          <div class="card-header">
                <h3>Formulario</h3>
          </div>
          <div class="card-body">

            <form action="{{route('solicitud.sol_rechazar')}}" method="POST" role="form" id="form_rechazar">
                @csrf
                @method('POST')
            <div class="row">
                <div class="col-8">
                    <label for="reservorio">Imagen Vista Previa</label>
                    <div class="input-group ">
                        <input type="hidden" name="id_solicitud" value="{{$solicitud->id}}">
                        <img src="{{asset('images/no-disponible.png')}}" width="100%" height="342px"alt="Vista Previa" id="imgMap">
                        <input type="hidden" name="textMap" id="textMap">
                    </div>
                </div>
                <div class="col-4">
                    <label for="observaciones">Observaciones</label>
                    <div class="form-group">
                        <textarea class="form-control" name="observaciones" id="observaciones" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="concesion" class="checkbox">
                        <label for="concesion">Fuera del área de concesión</label>
                    </div>

                </div>


            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-danger">Rechazar</button>
            </form>
          </div>

      </div>
</div>




@stop



@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset('vendor/leaflet/js/leaflet.js')}}" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/esri-leaflet.js')}}" integrity="sha512-6LVib9wGnqVKIClCduEwsCub7iauLXpwrd5njR2J507m3A2a4HXJDLMiSZzjcksag3UluIfuW1KzuWVI5n/cuQ==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/esri-leaflet-geocoder.js')}}" integrity="sha512-8twnXcrOGP3WfMvjB0jS5pNigFuIWj4ALwWEgxhZ+mxvjF5/FBPVd5uAxqT8dd2kUmTVK9+yQJ4CmTmSg/sXAQ==" crossorigin=""></script>
<script src="{{asset('vendor/leaflet/js/easy-button.js')}}"></script>
<script src="{{asset('js/html2canvas.min.js')}}"></script>
<script src="{{asset('js/leaflet_export.js')}}"></script>
<script src="{{asset('js/mapas.js')}}"></script>

<script>
    document.addEventListener('DOMContentLoaded',()=>{
        initMap({{$solicitud->x_aprox}}, {{$solicitud->y_aprox}});
        // document.querySelector('#map').style.width = window.screen.width ;
    });
    document.querySelector('#concesion').addEventListener('click', (e)=>{
        const observaciones = document.querySelector('#observaciones');
        if(e.target.checked){
            observaciones.value = 'Se encuentra fuera del área de concesión';
        }else{
            observaciones.value = '';
        }
    })
</script>
<script>

    document.getElementById('form_rechazar').addEventListener('submit',(e)=>{
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
            document.querySelector('#form_rechazar').submit()
        }
    })

</script>
@stop
@section('css')
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/leaflet.css')}}" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/esri-leaflet-geocoder.css')}}" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
    <link rel="stylesheet" href="{{asset('vendor/leaflet/css/easy-button.css')}}">

@stop
