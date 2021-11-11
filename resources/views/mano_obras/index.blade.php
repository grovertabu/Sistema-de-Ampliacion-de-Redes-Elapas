
    <a href="{{route('mano_obra.create',$id_ejecucion)}}" class="btn btn-warning btn-rounded" style="float: right; margin-right: 5px;">
        Registrar Mano de Obra <i class="fas fa-hammer"></i>
    </a>

<div class="table table-bordered table-hover dataTable table-responsive w-100">
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
            <th width="50">PROVEEDDOR</th>
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

