@extends('adminlte::page')

@section('title', 'Uuarios')

@section('content_header')
<a href="{{route('users.create')}}" class="btn btn-success btn-rounded" style="float: right;">
    Registrar Usuario <i class="fa fa-plus-square"></i>
</a>
    <h1>LISTA DE USUARIOS</h1>
   
@stop


@section('content')

<div class="table table-bordered table-hover dataTable table-responsive">
    <table class="table table-bordered datatable" id="example">
    <thead>
      <tr>	
        <th width="50">Id</th>
        <th>Nombre</th>
        <th width="350">Email</th>
        <th>Roles</th>
        <th width="100">Acciones</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                  <ul>
                  @foreach($user->roles as $rol)
                  <li>{{$rol->name}}</li>
                  @endforeach
                  </ul>
                </td>
                <td>
                    <a href='{{route('users.edit',$user->id)}}' 
                    class='btn btn-info btn-icon btn-xs'>Asignar rol <i class="fas fa-pencil-alt"></i></a>
                    <form action="">
                        @csrf
                        {{-- @method('delete') --}}
                        {{-- <button class='btn btn-danger btn-icon btn-xs' type="submit">Eliminar  <i class="fas fa-trash"></i></button> --}}
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Acciones</th>
        </tr>
    </tfoot>
</table>
</div>
@stop

@section('js')
    <script>
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop