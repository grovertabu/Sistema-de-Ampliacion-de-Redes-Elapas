@extends('adminlte::page')

@section('title', 'Cronograma')

@section('content_header')
    <h1>CRONOGRAMA </h1>
@stop

@section('content')
<div class="justify-content-center row">
    <!-- left column -->
    <div class="col-md-8">
    <!-- general form elements -->
        <div class="card card-primary ">
        <div class="card-header">
            <h3 class="card-title">Registrar Material</h3>
        </div>
        <!-- /.card-header -->
        <!-- formulario inicio -->
        <form action="{{route('materials.registrar')}}" method="POST" role="form" id="form_materials">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_material">Nombre del material</label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                        </div>
                        <input type="text" name="nombre_material" id="nombre_material" class="form-control" placeholder="nombre del solicitante">
                    </div>
                </div>
                <div class="form-group">
                    <label for="nombre_material">Observaciones</label>
                    <div class="input-group ">
                        <textarea name="observaciones" id="observaciones" class="form-control" ></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nombre_material">Estado</label>
                    <select class="form-control" name="estado" id="estado">
                        <option value="disponible">Disponible</option>
                        <option value="no disponible">No Disponible</option>
                      </select>
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