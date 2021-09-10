{{-- CUADRO DE COMPUTOS METRICOS ELAPAS --}}
@extends('adminlte::page')

@section('title', 'Registrar_Computo_e')


@section('content')
<div class="justify-content-center row">
    <div class="col-md-6">
        <!-- general form elements -->
            <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title">CUADRO DE COMPUTOS METRICOS ELAPAS</h3>
            </div>
            <!-- /.card-header -->
            <!-- formulario inicio -->
            <form action="{{route('descargo.registrar_computo_e')}}" method="POST" class="create" role="form" id="form_materials">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre_actividad">Actividad</label>
                        <select class="form-control  select2" name="actividad_descargo_id" id="actividad_descargo_id">
                            <option selected value="0">---Seleccione actividad---</option>
                            @foreach ($actividads as $actividad )
                                <option  value="{{$actividad->id}}">{{$actividad->nombre_actividad}}</option>
                            @endforeach
                        </select><br>
                        <input type="text" name="nombre_actividad" id="nombre_actividad" class="form-control" placeholder="Nombre de actividad(opcional)">
                        <input type="hidden" name="nro" id="nro" value="0">
                        <input type="hidden" name="actividad_id" id="actividad_id" value="{{$ultimo_registro->id+1}}">
                        <input type="hidden" name="id_informe" id="id_informe" value="{{$informe->id}}">
                        <input type="hidden" name="fecha_descargo" id="fecha_descargo" value="{{$fecha_descargo}}">
                        <input type="hidden" name="id_inspector" id="id_inspector" value="{{$valor}}">
                    </div>
                    <div class="form-group">
                        <label for="nombre_material">Ancho</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                            </div>
                            <input type="number" step="0.01" name="ancho" id="ancho" class="form-control" placeholder="Ancho">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre_material">Alto</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                            </div>
                            <input type="number" step="0.01" name="alto" id="alto" class="form-control" placeholder="Alto...">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-block btn-primary">Registrar</button>
                </div>
                <!-- /.card-body -->
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