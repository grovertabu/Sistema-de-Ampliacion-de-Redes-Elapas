@extends('adminlte::page')

@section('title', 'Actualizar solicitud')

@section('content_header')
    <h1>ELAPAS</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="justify-content-center row">
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
                        <input type="text" name="x_aprox" id="x_aprox" value="{{$solicitud->x_aprox}}">
                        <input type="text" name="y_aprox" id="y_arpox" value="{{$solicitud->y_aprox}}">
                    </div>
                </div><br>
                <div class="card-footer">
                    <button type="button" class="btn btn-block btn-outline-success" data-toggle="modal" data-target="#exampleModal">
                    Actualizar ubicacion aproximada</button>
                </div>
                {{-- Modal para el registrar coordenadas --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <h2>mi primer modal</h2>
                          {{-- fin del mapa --}}
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button type="button" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                      </div>
                    </div>
                  </div>
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
</div>


@stop

@section('js')
    <script>
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop