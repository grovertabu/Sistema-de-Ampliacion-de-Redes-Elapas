@extends('adminlte::page')

@section('title', 'Material')

@section('content_header')
    <h1>DESCARGO DE MATERIALES</h1>
@stop

@section('content')
<div class="justify-content-center row">
    <!-- left column -->
    <div class="col-md-6">
    <!-- general form elements -->
        <div class="card card-primary ">
        <div class="card-header">
            <h3 class="card-title">APORTE MATERIAL VECINOS</h3>
        </div>
        <!-- /.card-header -->
        <!-- formulario inicio -->
        <form action="{{route('descargo.registrar_aporte_v')}}" method="POST" class="create" role="form" id="form_materials">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_material">Descripción del material</label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                        </div>
                        <input type="hidden" name="id_informe" id="id_informe" value="{{$informe->id}}">
                        <input type="hidden" name="fecha_descargo" id="fecha_descargo" value="{{$fecha_descargo}}">
                        <input type="hidden" name="id_inspector" id="id_inspector" value="{{$valor}}">
                        <input type="text" name="desc_material" id="desc_material" class="form-control" placeholder="Descripción del material">
                    </div>
                </div>
                <div class="form-group">
                    <label for="nombre_material">Unidad</label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                        </div>
                        <input type="text" name="unidad" id="unidad" class="form-control" placeholder="Unidad...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="nombre_material">Canditdad</label>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                        </div>
                        <input type="number"  name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad...">
                    </div>
                        
                    </div>
                    
                    <div class="col-6">
                        <label for="nombre_material">Precio Unitario</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                            </div>
                            <input type="number" step="0.01" name="precio_unitario" id="precio_unitario" class="form-control" placeholder="0.00">
                        </div>
                        
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-block btn-primary">Registrar</button>
                </div>
                </form>
            </div>
            <!-- /.card-body -->
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