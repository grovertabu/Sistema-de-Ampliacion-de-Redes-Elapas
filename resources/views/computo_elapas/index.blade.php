
    <!-- /.card-header -->
    <!-- formulario inicio -->
    @php
    $n=1;
@endphp
    <a href="{{route('descargo.crear_computo_e',[$informe->id,$fecha_descargo,$valor])}}" class="btn btn-warning btn-rounded" style="float: right; margin-right: 5px;">
        Registrar Computo <i class="fas fa-fw fa-box-open"></i></a> <br>


@if($computos==[])
    <p>No hay Registros</p>
@else
<div class="table table-bordered table-hover dataTable table-responsive">
    <table class="table table-bordered datatable" id="example">
    <thead>
        <tr>	
            <th width="170">#</th>
            <th >ACTIVIDAD</th>
            <th>NRO</th>
            <th >ALTO</th>
            <th width="150">ANCHO</th>
            <th width="150">LARGO</th>
            <th width="150">ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach($computos as $value)
        <tr>
            <td>{{$n++}}</td>
            <td>{{$value->nombre_a}}</td>
            <td>{{$value->nro}}</td>
            <td>{{$value->ancho}}</td>
            <td>{{$value->alto}}</td>
            <td>{{$value->largo}}</td>
            <td>
                <form action="{{route('descargo.eliminar_aporte',[$value->id_aporte,$fecha_descargo,$valor])}}" method="POST">
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