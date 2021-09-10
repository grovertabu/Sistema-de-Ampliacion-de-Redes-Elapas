<table class="table table-bordered datatable" id="example">
    <thead>
        <tr>	
            <th>Nro</th>
            <th>BARRIO</th>
            <th>NOMBRE DEL SOLICITANTE</th>
            <th>CELULAR</th>
            <th>MIERCOLES</th>
            <th>JUEVES</th>
            <th>INSPECTOR</th>
            <th width="120">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cronogramas as $cronograma)
        <tr>
            <td>{{$n++}}</td>
            <td>{{$cronograma->zona}}</td>
            <td>{{$cronograma->nombre_sol}}</td>
            <td>{{$cronograma->celular}}</td>
            @if($dias[(date('N', strtotime($cronograma->fecha_inspe)))]=="miércoles")
                <td>{{$cronograma->fecha_inspe}}</td>
                <td></td>
            @elseif ($dias[(date('N', strtotime($cronograma->fecha_inspe)))]=="jueves")
                <td></td>
                <td>{{$cronograma->fecha_inspe}}</td>
            @else
                <td></td>
                <td></td>
            @endif
            <td>{{$cronograma->name}}</td>
            <td>
            </td>
        </tr>
        @endforeach

        
    </tbody>
    <tfoot>
        <tr>
            <th>Nro</th>
            <th>BARRIO</th>
            <th>NOMBRE DEL SOLICITANTE</th>
            <th>CELULAR</th>
            <th>MIERCOLES</th>
            <th>JUEVES</th>
            <th>INSPECTOR</th>
            <th>Acciones</th>
        </tr>
    </tfoot>
</table>