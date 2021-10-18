@extends('adminlte::page')

@section('title', 'Asign_Material')

@section('content_header')
    <h1>Asignacion de Material</h1>
@stop

@section('content')
<div class="justify-content-center row">
    <!-- left column -->
    <div class="col-md-6">
    <!-- general form elements -->
        <div class="card card-primary ">
        <div class="card-header">
            <h3 class="card-title">ASIGNAR MATERIAL</h3>
        </div>
        <!-- /.card-header -->
        <!-- formulario inicio -->
        <form action="{{route('material_informe.store')}}" method="POST" role="form" id="form_materials">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="informe">Informe</label>
                    <div class="input-group ">
                        <input type="hidden" name="id_informe" id="id_informe" value="{{$informe->id}}">
                        <p class="form-control">{{$informe->solicitud->nombre_sol}} - {{$informe->solicitud->calle_sol}}</p>

                        {{--  --}}
                    </div>
                </div>
                <div class="form-group">
                    <label for="nombre_material">Descripcion Material</label>
                    <div class="input-group ">
                        <select class="form-control select2" name="id_material"  id="id_material" required>
                            <option value="0" selected>---Seleccione Material---</option>
                            @foreach ($materials as $material )
                                <option  value="{{$material->id}}">{{$material->nombre_material.' ('.$material->unidad_med.')'}}</option>
                            @endforeach
                        </select>

                        {{--  --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="cantidad">Cantidad de Material</label>
                        <div class="input-group col-md-12 ">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                            </div>
                            <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad de Material" required>
                        </div>

                    </div>
                    <div class="form-group col-6">
                        <label for="observador">Observador</label>
                        <div class="input-group" >
                            <div class="input-group-prepend">
                                <div >
                                    <p style="margin-right: 5px">Elapas
                                        <input type="radio" value ="Elapas" checked name="observador" style="margin-top:5px; margin-right: 3px">
                                    </p>
                                </div>
                            </div>
                            <div class="input-group-prepend">
                                <div >
                                    <p>Vecinos
                                        <input type="radio" value ="Vecinos" name="observador" style="margin-top:5px; margin-right: 3px">
                                    </p>
                                </div>
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
<div>
</div>
<div class="table table-bordered table-hover dataTable table-responsive">
    <table class="table table-bordered datatable" id="example">
    <thead>
        <tr>
            <th width="170">ID</th>
            <th>MATERIAL</th>
            <th width="150">CANTIDAD <br> SOLICITADA </th>
            <th width="150">UNIDAD <br> MEDIDA</th>
            <th width="150">OBSERVADOR</th>
            <th width="150">ACCIONES</th>
        </tr>
    </thead>
    <tbody id="contenedor-materiales">
        @foreach ($mat_inf as $mat)
        <tr>
            <td>{{$mat->id}}</td>
            <td align="center">{{$mat->material_n}}</td>
            <td>{{$mat->cantidad}}</td>
            <td>{{$mat->unidad}}</td>
            <td>{{$mat->observador}}</td>
            <td>
                <form action="{{route('material_informe.eliminar', $mat->id)}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-danger btn-icon btn-xs" type="submit">Eliminar  <i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach

        </tbody>
</table>
</div>


@stop

@section('js')
    <script>
    $('.select2').select2();
    </script>
    <script>
        document.getElementById('form_materials').addEventListener('submit', (e)=>{
            e.preventDefault();
            let material = document.getElementById('id_material').selectedOptions[0].value;
            if(material != '0'){
                document.getElementById('form_materials').submit();
            }else{

            }
        })
    </script>

@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
