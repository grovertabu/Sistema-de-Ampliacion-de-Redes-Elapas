@extends('adminlte::page')

@section('title', 'Actividad Mano de Obra')

@section('content_header')
    <h1>ACTIVIDADES DE MANO DE OBRA</h1>
@stop

@section('content')
<div class="justify-content-center row">
    <!-- left column -->
    <div class="col-md-8">
    <!-- general form elements -->
        <div class="card card-primary ">
        <div class="card-header">
            <h3 class="card-title">Registrar Actividad</h3>
        </div>
        <!-- /.card-header -->
        <!-- formulario inicio -->
        <form action="{{route('actividad.store')}}" method="POST" class="create" role="form" id="form_materials">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_material">Nombre de la actividad</label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                        </div>
                        <input type="text" name="descripcion" id="nombre_actividad" class="form-control" placeholder="nombre de la actividad" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_material">Unidad de Medida</label>
                            <div class="input-group ">
                                <input type="text" name="unidad_medida"  class="form-control" placeholder="Unidad de medida de la actividad" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_material">Precio Unitario</label>
                            <div class="input-group ">
                                <input type="number" min="0.00" step="0.01" name="precio" id="nombre_actividad" class="form-control" placeholder="Precio unitario de la actividad" required>
                            </div>
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

@stop

@section('js')
    <script>
    $('.select2').select2();
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
