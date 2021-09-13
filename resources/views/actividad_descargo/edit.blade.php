@extends('adminlte::page')

@section('title', 'Editar actividad')


@section('content')
<div class="justify-content-center row">
    <!-- left column -->
    <div class="col-md-8">
    <!-- general form elements -->
        <div class="card card-primary ">
        <div class="card-header">
            <h3 class="card-title">Editar actividad</h3>
        </div>
        <!-- /.card-header -->
        <!-- formulario inicio -->
        <form action="{{route('actividad.update',$actividad)}}" method="POST" role="form" id="form_actividad">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_actividad">Nombre de la actividad</label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                        </div>
                        <input type="text" name="nombre_actividad" id="nombre_actividad" class="form-control" value="{{$actividad->nombre_actividad}}" placeholder="nombre de la actividad">
                    </div>
                </div>
                <div class="form-group">
                    <label for="nombre_material">Estado</label>
                    <select class="form-control" name="estado" id="estado">
                        <option value="habilitado">Habilitado</option>
                        <option value="deshabilitado">Deshabilitado</option>
                      </select>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-block btn-primary">Guardar</button>
            </div>
        </form>
        {{-- Fin de formulario --}}
        </div>
    </div>
</div>

@stop

@section('js')
    <script>
    $('.select2').select2();
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop