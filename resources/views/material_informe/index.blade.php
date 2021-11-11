
    <!-- /.card-header -->
    <!-- formulario inicio -->

    <a href="{{route('informes.registrar_material',$informe->id)}}" class="btn btn-warning btn-rounded" style="float: right; margin-right: 5px;">
        Registrar material <i class="fas fa-fw fa-box-open"></i>
    </a>


@if($mat_inf==[])
    <p>No se asignaron materiales</p>
@else
<div class="table table-bordered table-hover dataTable table-responsive">
    <table class="table table-bordered datatable" id="example">
    <thead>
        <tr>
            <th width="170">ID</th>
            <th >MATERIAL</th>
            <th width="150">CANTIDAD <br> SOLICITADA </th>
            <th width="150">UNIDAD <br> MEDIDA</th>
            <th width="150">ACCIONES</th>
        </tr>
    </thead>
    <tbody>

        @foreach($mat_inf as $value)
        <tr>
            <td>{{$value->id}}</td>
            <td align="center">{{$value->material_n}}</td>
            <td>{{$value->cantidad}}</td>
            <td>{{$value->u_medida}}</td>
            <td>
                <form action="{{route('material_informe.destroy',$value->id)}}" method="POST">
                    @csrf
                    @method('delete')
                    <button class='btn btn-danger btn-icon btn-xs' type="submit">Eliminar  <i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endif


<script>
    $('.select2').select2();
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
</script>
