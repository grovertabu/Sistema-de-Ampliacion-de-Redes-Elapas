@extends('adminlte::page')

@section('title', 'Actividad')

@section('content_header')
@stop
@php
    $n=1;
@endphp
@section('content')
    <h1>ELAPAS - ACTIVIDAD DE MANO DE OBRA
        <a href="{{route('actividad.create')}}" class="btn btn-success btn-rounded" style="float: right;">
            Registrar actividad <i class="fa fa-plus-square"></i>
        </a>
    </h1>
    <div class="table table-bordered table-hover dataTable table-responsive">
        <table class="table table-bordered datatable" id="example">
        <thead>
          <tr>
            <th>NRO</th>
            <th>NOMBRE</th>
            <th>UNIDAD DE MEDIDA</th>
            <th>PRECIO UNITARIO</th>
            <th>ACCIONES</th>

          </tr>
        </thead>
        <tbody>
            @foreach ($actividads as $actividad)
                <tr>
                    <td>{{$n++}}</td>
                    <td align="center">{{$actividad->descripcion}}</td>
                    <td align="center">{{$actividad->unidad_medida}}</td>
                    <td align="center">{{$actividad->precio_unitario}}</td>
                    <td>
                        <a href='{{route('actividad.edit',$actividad)}}'
                        class='btn btn-info btn-icon'><i class="fas fa-pencil-alt"></i></a>
                        <form action="{{route('actividad.destroy',$actividad)}}" class="d-inline" method="POST">
                            @csrf
                            @method('delete')
                            <button class='btn btn-danger btn-icon' type="submit"><i class="fas fa-trash"></i></button>

                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>NRO</th>
                <th>NOMBRE</th>
                <th>UNIDAD DE MEDIDA</th>
                <th>PRECIO UNITARIO</th>
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
