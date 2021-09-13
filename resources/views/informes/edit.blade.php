@extends('adminlte::page')

@section('title', 'Llenar informe')

@section('content_header')
    <style>
    #map {
        height: 70%;
        padding: 40%;
      }
    </style>
    <h1>Informes de ampliacion de redes</h1>
@stop

@section('content')
<div class="justify-content-center row">
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
                        <label for="fecha_hora_in">Fecha de inspeccion</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            </div>
                            <input class="form-control" name="fecha_hora_in" type="datetime-local" value="{{$informe->fecha_hora_in}}" id="example-datetime-local-input">
                        </div>
                        
                    </div>
                    <div class="col-5"><br>
                        <label for="espesifiar">Espesifiar el area de concesion</label><br>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="espesifiar_in" id="inlineRadio1"  value="Si"> Si
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="espesifiar_in" id="inlineRadio2" value="No"> No
                            </label>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="Ubicacion_georeferencial">Ubicacion Georeferencial</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            
                                <input type="text" name="ubicacion_geo" id="ubicacion_geo" class="form-control" value="" placeholder="Ubicacion georeferencial">
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
                                <input type="text" name="x_exact" id="x_exact" class="form-control" placeholder="Indicar coordenada Lat" value="{{$informe->solicitud->x_aprox}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="Longitud">Longitud</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                                <input type="text" name="y_exact" id="y_exact" class="form-control" placeholder="Indicar Coordenada Lng" value="{{$informe->solicitud->y_aprox}}">
                        </div>
                    </div>
                    <div class="card-footer">
                    
                        <button type="button" class="btn btn-block btn-outline-success" data-toggle="modal" data-target=".bd-example-modal" id="btnMapaExacto" >
                        Registrar ubicacion exacta</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label for="longitud_in">Longitud de la Ampliacion</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                                <input type="text" name="longitud_in" id="longitud_in" class="form-control" placeholder="Longitud">
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="diametro_in">Diametro de la ampliacion</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                                <input type="text" name="diametro_in" id="diametro_in" class="form-control" placeholder="Diametro">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="Longitud">Numero de Beneficiarios</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                            </div>
                                <input type="text" name="num_ben_in" id="num_ben_in" class="form-control" placeholder="Nº:....">
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="Familia">-</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                            </div>
                                <input type="text" name="num_flia_in" id="num_flia_in" class="form-control" placeholder="Flia::....">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6"><br>
                        <label for="espesifiar">Condiciones de Rasante</label><br>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="condicion_rasante" id="inlineRadio1" value="BUENA"> BUENA
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="condicion_rasante" id="inlineRadio2" value="MALA"> MALA
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
                                <input type="text" name="reservorio" id="reservorio" class="form-control" placeholder="Nº:....">
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
<div class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div id="map" class="modal-content">
        
      </div>
    </div>
  </div>
  
  {{-- Modal fin --}}

  <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBUW9zimMRIYLdOBY4FrSyqd13IaJ7N4Y0">
    </script>
@stop

@section('js')
    <script>
    $('.select2').select2();
    </script>


@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop