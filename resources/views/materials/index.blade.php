@extends('adminlte::page')

@section('title', 'Material')

@section('content_header')
@stop
@php
    $n=1;
@endphp
@section('content')
    <h1>ELAPAS - MATERIALES
        <a href="{{route('materials.create')}}" class="btn btn-success btn-rounded" style="float: right;">
            Registrar Material <i class="fa fa-plus-square"></i>
        </a>
    </h1>
    <div class="table table-bordered table-hover dataTable table-responsive">
        <table class="table table-bordered datatable" id="example">
        <thead>
          <tr>
            <th>NRO</th>
            <th>NOMBRE MATERIAL</th>
            <th>PRECIO U.</th>
            <th>OBSERVACION</th>
            <th width="80">ESTADO </th>


            <th>ACCIONES</th>

          </tr>
        </thead>
        <tbody>
            @foreach ($materials as $material)
                <tr>
                    <td>{{$n++}}</td>
                    <td>{{$material->nombre_material}}</td>
                    <td>{{number_format($material->precio_unitario,2)}}</td>
                    <td>{{$material->observaciones}}</td>

                        @if($material->estado=="disponible")
                        <td align="center"><span class="badge badge-success" >{{$material->estado}}</span></td>
                        @else
                        <td align="center"><span class="badge badge-danger" >{{$material->estado}}</span></td>
                        @endif

                    <td>
                        <a href='{{route('materials.edit',$material)}}'
                        class='btn btn-info btn-icon' title="Editar"><i class="fas fa-pencil-alt"></i></a>
                        <form action="{{route('materials.destroy',$material)}}" class="d-inline" method="POST">
                            @csrf
                            @method('delete')
                            <button class='btn btn-danger btn-icon' title="Eliminar" type="submit"><i class="fas fa-trash"></i></button>

                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>NRO</th>
                <th>NOMBRE MATERIAL</th>
                <th>PRECIO U.</th>
                <th>OBSERVACION</th>
                <th>ESTADO </th>

                <th>ACCIONES</th>


            </tr>
        </tfoot>
    </table>
</div>

@stop
@section('footer')
<strong>{{date("Y")}} || ELAPAS - SISTEMA DE AMPLIACION DE REDES DE AGUA </strong>
@stop
@section('js')
    <script>
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
