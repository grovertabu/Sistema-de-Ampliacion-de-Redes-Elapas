
    <!-- /.card-header -->
    <!-- formulario inicio -->
@php
    $n=1;
@endphp
    <a href="{{route('descargo.crear_aport_v',[$informe->id,$fecha_descargo,$valor])}}" class="btn btn-warning btn-rounded" style="float: right; margin-right: 5px;">
        Registrar Aporte <i class="fas fa-fw fa-box-open"></i></a> <br>


@if($aportes==[])
    <p>No hay Registros</p>
@else
<div class="table table-bordered table-hover dataTable table-responsive">
    <table class="table table-bordered datatable" id="example">
    <thead>
        <tr>	
            <th width="170">Nro</th>
            <th >Descripcion</th>
            <th width="150">CANTIDAD</th>
            <th width="150">UNIDAD</th>
            <th width="150">Precio <br> Unitario</th>
            <th width="150">ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach($aportes as $value)
        <tr>
            <td>{{$n++}}</td>
            <td>-----------</td>
            <td>{{$value->cantidad}}</td>
            <td>{{$value->unidad}}</td>
            <td>{{$value->p_unitario}}</td>
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