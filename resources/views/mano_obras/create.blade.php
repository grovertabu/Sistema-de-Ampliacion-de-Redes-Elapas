@extends('adminlte::page')

@section('title', 'Asign_Material')

@section('content_header')
    <h1 id="txtActividad">Registro de Mano de Obra</h1>

@stop

@section('content')

    <!-- left column -->
    <div class="justify-content-center row" >
    <!-- general form elements -->
        <div class="card card-primary ">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">REGISTRO DE MANO DE OBRA</h3>
                </div>
                <div class="form-group col-sm-6">
                    <select class="form-control select2" onchange="habilitarForm(this.value)"; name="actividad_id" id="actividad_id">
                        <option selected value="0">---Seleccione Actividad---</option>
                        @foreach ($actividad as $act )
                            <option  value="{{$act->id}}-{{$act->unidad_medida}}-{{$act->precio_unitario}}">{{$act->descripcion}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <!-- /.card-header -->
        <!-- formulario inicio -->
        <form action="{{route('mano_obra.store')}}" method="POST" role="form" id="form_actividad">
            @csrf
            <div class="card-body">
                <input type="hidden" name="id_ejecucion" value="{{$ejecucion->id}}">
                <input type="hidden" name="id_informe" value="{{$ejecucion->informe_id}}">
                <input type="hidden" name="id_actividad" id="id_actividad" value="">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="ancho">Ancho</label>
                        <div class="input-group">
                            <input class="form-control" type="number" min="0.00" step="0.01" oninput="calcularVolumen()"  name="ancho" id="ancho" placeholder="Ancho" >
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="cantidad">Alto</label>
                        <div class="input-group">
                            <input type="number" min="0.00" step="0.01" name="alto" id="alto" oninput="calcularVolumen()"   class="form-control" placeholder="Alto" >
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombre_material">Largo</label>
                        <div class="input-group">
                            <input class="form-control" type="number" min="0.00" step="0.01" oninput="calcularVolumen()"  name="largo" id="largo" placeholder="Largo">
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="cantidad">Unidad</label>
                        <div class="input-group">
                            <input type="text" name="unidad" id="unidad" onchange="calcularVolumen()" class="form-control" placeholder="Unidad de Medida"  disabled required>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="cantidad">Cantidad</label>
                        <div class="input-group">
                            <input type="number" min="0.00" step = "0.01" name="cantidad" onchange="calcularVolumen()" id="cantidad" class="form-control" placeholder="Cantidad de Material" required>
                        </div>

                    </div>
                    <div class="form-group col-6">
                        <label for="cantidad">Precio Unitario</label>
                        <div class="input-group">
                            <input type="number" min="0.00" step="0.01" name="precio_uni" id="precio" class="form-control" placeholder="Precio Unitario del Material" required>
                        </div>

                    </div>

                </div>
                <div class="row">
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
                <button id="btnRegistrar" type="submit" class="btn btn-block btn-primary" disabled>Registrar</button>
            </div>
        </form>
        {{-- Fin de formulario --}}
        </div>
    </div>




<div class="table table-bordered table-hover dataTable table-responsive">
    <table class="table table-bordered datatable" id="example">
    <thead>
        <tr>
            <th width="50">ID</th>
            <th width="150">DESCRIPCION</th>
            <th width="50">ALTO</th>
            <th width="50">ANCHO</th>
            <th width="50">LARGO</th>
            <th width="50">CANTIDAD</th>
            <th width="50">UNIDAD <br> MEDIDA</th>
            <th width="50">PRECIO <br> UNITARIO</th>
            <th width="50">OBSERVADOR</th>
            <th width="50">ACCIONES</th>
        </tr>
    </thead>
    <tbody id="contenedor-materiales">
        @foreach ($mano_obra as $mat)
        <tr>
            <td>{{$mat->mano_obras_id}}</td>
            <td align="center">{{$mat->descripcion}}</td>
            <td>{{$mat->alto}}</td>
            <td>{{$mat->ancho}}</td>
            <td>{{$mat->largo}}</td>
            <td>{{$mat->cantidad}}</td>
            <td>{{$mat->unidad}}</td>
            <td>{{$mat->precio_uni}}</td>
            <td>{{$mat->observador}}</td>
            <td>
                <form action="{{route('mano_obra.eliminar', $mat->mano_obras_id)}}" method="POST">
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
    <script src="{{asset('js/mano_obra.js')}}"></script>

@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
