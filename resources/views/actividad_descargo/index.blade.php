@extends('adminlte::page')

@section('title', 'Actividad')

@section('content_header')
@stop
@php
    $n=1;
@endphp
@section('content')
    <h1>ELAPAS - ACTIVIDAD DE DESCARGOS
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
            <th>ESTADO </th>                
            <th>ACCIONES</th>
            
          </tr>
        </thead>
        <tbody>
            @foreach ($actividads as $actividad)
                <tr>
                    <td>{{$n++}}</td>
                    <td align="center">{{$actividad->nombre_actividad}}</td>
                    @if($actividad->estado=="habilitado")
                    <td align="center"><span class="badge badge-success" >{{$actividad->estado}}</span></td>
                    @else
                    <td align="center"><span class="badge badge-danger" >{{$actividad->estado}}</span></td>
                    @endif
                    <td>
                        <a href='{{route('actividad.edit',$actividad)}}' 
                        class='btn btn-info btn-icon btn-xs'>Editar <i class="fas fa-pencil-alt"></i></a>
                        <form action="{{route('actividad.destroy',$actividad)}}" class="d-inline" method="POST">
                            @csrf
                            @method('delete')
                            <button class='btn btn-danger btn-icon btn-xs' type="submit">Eliminar  <i class="fas fa-trash"></i></button>
                        
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>NRO</th>
                <th>NOMBRE MATERIAL</th>
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