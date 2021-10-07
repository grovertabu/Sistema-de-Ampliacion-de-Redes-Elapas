@extends('adminlte::page')

@section('title', 'Asign_Material')

@section('content_header')
    <h1>Registro de Mano de Obra</h1>
@stop

@section('content')
<div class="justify-content-center row">
    <!-- left column -->
    <div class="col-md-6">
    <!-- general form elements -->
        <div class="card card-primary ">
        <div class="card-header">
            <h3 class="card-title">REGISTRO DE MANO DE OBRA</h3>
        </div>
        <!-- /.card-header -->
        <!-- formulario inicio -->
        <form action="{{route('mano_obra.store')}}" method="POST" role="form" id="form_materials">
            @csrf
            <div class="card-body">
                {{-- <div class="form-group">
                    <label for="informe">Informe</label>
                    <div class="input-group ">
                        {{-- <p class="form-control">{{$ejecucion->informe->solicitud->nombre_sol}} - {{$ejecucion->informe->solicitud->calle_sol}}</p> --}}
                        
                        {{--  --}}
                        {{--</div>
                        </div> --}}
                        {{$ejecucion}}
                        <input type="hidden" name="id_ejecucion" id="id_informe" value="{{$ejecucion->id}}">
                        <div class="row">

                    <div class="form-group col-md-6">
                        <label for="fecha_inspe">Fecha de ejecucion</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                            </div>
                            <input class="form-control" id="fecha_inspe" name="fecha_ejecucion" type="date" value="{{$ejecucion->fecha_progrnada}}">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nombre_material">Descripcion Mano de Obra</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="descripcion" id="" placeholder="Descripcion">
    
                            {{--  --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="cantidad">Cantidad</label>
                        <div class="input-group">
                            <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="Cantidad de Material" required>
                        </div>
                        
                    </div>
                    
                    <div class="form-group col-6">
                        <label for="cantidad">Precio Unitario</label>
                        <div class="input-group">
                            <input type="text" name="precio_uni" id="cantidad" class="form-control" placeholder="Cantidad de Material" required>
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
            <th>DESCRIPCION</th>
            <th width="150">UNIDAD <br> MEDIDA</th>
            <th width="150">CANTIDAD</th>
            <th width="150">PRECIO <br> UNITARIO</th>
            <th width="150">ACCIONES</th>
        </tr>
    </thead>
    <tbody id="contenedor-materiales">
        @foreach ($mano_obra as $mat)
        <tr>
            <td>{{$mat->id}}</td>
            <td align="center">{{$mat->descripcion}}</td>
            <td>{{$mat->unidad}}</td>
            <td>{{$mat->cantidad}}</td>
            <td>{{$mat->precio_uni}}</td>
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