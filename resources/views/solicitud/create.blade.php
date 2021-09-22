@extends('adminlte::page')

@section('title', 'Registrar solicitud')

@section('content_header')
    <style>
    #map {
        height: 70%;
        padding: 40%;
      }
    </style>
    <h1>ELAPAS</h1>
    <hr>
@stop

@section('content')

<div class="container-fluid">
    <div class="justify-content-center row">
      <!-- left column -->
        <div class="col-md-6">
        <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Registrar Solicitud</h3>
            </div>

            <!-- /.card-header -->
            <!-- formulario inicio -->
            <form action="{{route('solicitud.store')}}" method="POST" role="form" class="create" id="form_solicitud">
                @csrf
                <div class="card-body">
                <div class="form-group">
                    <label for="nombre_sol">Nombre del Solicitante</label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="nombre_sol" id="nombre_sol" class="form-control {{ $errors->has('nombre_sol') ? 'is-invalid' : '' }}" value="{{ old('nombre_sol') }}" autofocus placeholder="nombre del solicitante">
                        @error('nombre_sol')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="celular_sol">Celular</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="text"  name="celular_sol" id="celular_sol" class="form-control {{ $errors->has('celular_sol') ? 'is-invalid' : '' }}" value="{{ old('celular_sol') }}"placeholder="Celular">
                            @if($errors->has('celular_sol'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('celular_sol') }}</strong>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                    
                    <div class="col-6">
                        <label for="zona_sol">Zona</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text"  name="zona_sol" id="zona_sol" class="form-control {{ $errors->has('zona_sol') ? 'is-invalid' : '' }}" value="{{ old('zona_sol') }}" placeholder="Zona">
                            @if($errors->has('zona_sol'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('zona_sol') }}</strong>
                            </div>
                            @endif
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
                            <input type="text"  name="calle_sol" id="calle_sol" class="form-control {{ $errors->has('calle_sol') ? 'is-invalid' : '' }}" value="{{ old('calle_sol') }}" placeholder="Calle">
                            @if($errors->has('calle_sol'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('calle_sol') }}</strong>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                    
                    <div class="col-4">
                        <label for="exampleInputEmail1">fecha</label>
                        <input type="date"  name="fecha_sol" id="fecha_sol" class="form-control" value="{{date("Y-m-d")}}">
                        <input type="hidden" name="estado_sol" id="estado_sol" value="pendiente">
                        <input type="hidden" name="x_aprox" id="x_aprox" {{-- value="-19.034432" --}}>
                        <input type="hidden" name="y_aprox" id="y_aprox" {{-- value="-65.264812" --}}>
                    </div>
                </div><br>
                <div class="card-footer">
                    
                    <button type="button" class="btn btn-block btn-outline-success" data-toggle="modal" data-target=".bd-example-modal-lg" id="btnMapaRegistrar" >
                    Registrar ubicacion aproximada</button>
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
</div>
<hr>
{{-- Modal para el registrar coordenadas --}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
{{-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyA-AB-9XZd-iQby-bNLYPFyb0pR2Qw3orw"></script> --}}
<script >
//     var lati= parseFloat(document.getElementById('x_aprox').value);
//     var long= parseFloat(document.getElementById('y_aprox').value);
//     alert(lati)
//   	var coord= {lat:lati ,lng: long}
//     var myOptions = {
//           zoom: 15,
//           center: coord,
//           mapTypeId: 'roadmap'
//       };
//    map = new google.maps.Map(document.getElementById('map'), myOptions);
//    var marker = new google.maps.Marker({
//        position: coord,
//        map: map
//    })

document.querySelector('#form_solicitud').addEventListener('submit',(e)=>{
    e.preventDefault();
    const x_aprox = document.getElementById('x_aprox').value;
    const y_aprox = document.getElementById('y_aprox').value;
    console.log(x_aprox +' '+ y_aprox);
    if(x_aprox != '-19.034432' && y_aprox != '-65.264812'){
        var formData = new FormData(e.target);
        
        $.ajax({
                url: e.target.action,
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                      window.location.reload();
                }
        });
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Algo salió mal!',
        })
    } 
}) 

</script>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    
@stop