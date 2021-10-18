@extends('adminlte::page')

@section('title', 'Autorizacio')
@php
    $n=1;
@endphp
@section('content_header')
@stop

@section('content')
    <h1>ELAPAS - Informes Autorizados
        {{-- @can('informes.create')
        <a href="{{route('informes.create')}}" class="btn btn-success btn-rounded float-md-right" >
            Registrar Informe <i class="fa fa-plus-square"></i>
        </a>
        @endcan --}}

    </h1>
    <div class="table table-bordered table-hover dataTable table-responsive">
        <table class="table table-bordered datatable" id="example">
        <thead>
          <tr>
            <th>NRO</th>
            <th>ZONA O BARRIO</th>
            <th>NOMBRE SOLICITANTE</th>
            <th>FECHA <br>INSPECCION O EJECUCION PROGRAMADA</th>
            <th>ESTADO</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
            {{'el is es : '.$id}}
            {{'tipo: '.$aux}}
            @foreach ($informes as $inf)
                <tr>
                    <td>{{$n++}}</td>
                    <td>{{$inf->zona_sol}}</td>
                    <td>{{$inf->nombre_sol}}</td>
                    <td>@if($inf->estado == 'ejecutando')  {{$inf->fecha_programada}} @else {{$inf->fecha_inspeccion}} @endif</td>
                    <td align="center"><span class="badge badge-primary">{{$inf->estado}}</span></td>
                    <td>
                        @can('inspector')
                        @if($inf->estado=='autorizado' || $inf->estado=='ejecutando')
                        <button type="button" class='btn btn-warning btn-icon btn-xs' data-toggle="modal" data-target=".bd-example-modal-lg"
                        onclick="llamar('{{route('informes.show',$inf->id_informe)}}')">Material <i class="fas fa-box"></i></button>
                        <a href='{{route('mano_obra.create',$inf->id_ejecucion)}}'
                            class='btn btn-warning btn-icon btn-xs'>Registar Mano de Obra <i class="fas fa-hammer"></i></a>
                        @endif
                        @if($inf->estado == 'ejecutando' && $inf->fecha_ejecutada == null)
                        <button type="button" class='btn btn-primary btn-icon btn-xs' data-toggle="modal" data-target=".bd-example-modal-lg{{$inf->id_ejecucion}}"
                            onclick="">Generar Informes<i class="fas fa-file-pdf"></i></button>
                            <!-- Large modal -->
                           <div class="modal fade bd-example-modal-lg{{$inf->id_ejecucion}}" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow:hidden;">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ejecución</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="contenido" >
                                            <div class="justify-content-center row">
                                                <!-- left column -->
                                                <div class="col-md-12">
                                                <!-- general form elements -->
                                                    <div class="card card-primary ">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Prgramar Ejecución</h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- formulario inicio -->
                                                    <form action="{{route('ejecucion.ejecutada',$inf->id_ejecucion)}}" method="POST" role="form" id="form_materials">
                                                        @csrf
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="nombre_material">Solicitud</label>
                                                                <p class="form-control">{{$inf->nombre_sol}} - {{$inf->zona_sol}} </p>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="fecha_inspe">Fecha de ejecución</label>
                                                                <div class="input-group ">
                                                                    <div class="input-group-prepend">
                                                                    </div>
                                                                    <input class="form-control" id="fecha_inspe" name="fecha_ejecutada" type="date" value="" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                        <div class="card-footer">
                                                            <button type="submit" class="btn btn-block btn-primary">Programar</button>
                                                        </div>
                                                    </form>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endcan


                        <a href='{{route('descargarPDF.informe',$inf->id_informe)}}' target="_blank"
                        class='btn btn-danger btn-icon btn-xs'>Informe <i class="fas fa-file-pdf"></i></a>

                        @if($inf->estado!='registrado')
                            <a href='{{route('pedidoPDF.informe',$inf->id_informe)}}' target="_blank"
                            class='btn btn-danger btn-icon btn-xs'>Reporte de pedido <i class="fas fa-box-open"></i></a>
                        @endif
                        @if($inf->fecha_ejecutada != null)

                        <a href='{{route('reportePDF.informe_material',$inf->id_informe)}}' target="_blank"
                            class='btn btn-danger btn-icon btn-xs'>Informe Ampliacion <i class="fas fa-file-pdf"></i></a>

                        <a href='{{route('reportePDF.informe_descargo_material',$inf->id_informe)}}' target="_blank"
                            class='btn btn-danger btn-icon btn-xs'>Informe Descargo Material<i class="fas fa-box-open"></i></a>
                        @endif

                        @can('jefe-red')
                        @if($inf->estado=='ejecutando')
                            <a href='{{route('informes.firmar',$inf->id_informe)}}'
                            class='btn btn-success btn-icon btn-xs'>FIRMAR <i class="fas fa-pencil-alt"></i></a>
                        @endif
                        @endcan

                        {{-- @if($inf->estado=='firmado')

                            <a href='{{route('reportePDF.informe_material',$inf->id_informe)}}' target="_blank"
                            class='btn btn-danger btn-icon btn-xs'>Reporte ampliacion <i class="fas fa-box-open"></i></a>
                        @endif --}}
                        @can('jefe-red')
                        @if($inf->estado=='registrado')
                            <button type="button" class='btn btn-success btn-icon btn-xs' data-toggle="modal" data-target=".bd-example-modal-lg{{$inf->id_informe}}"
                                onclick="">Autorizar<i class="fas fa-pencil-alt"></i></button>
                                <!-- Large modal -->
                               <div class="modal fade bd-example-modal-lg{{$inf->id_informe}}" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow:hidden;">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Ejecución</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="contenido" >
                                                <div class="justify-content-center row">
                                                    <!-- left column -->
                                                    <div class="col-md-12">
                                                    <!-- general form elements -->
                                                        <div class="card card-primary ">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Prgramar Ejecución</h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <!-- formulario inicio -->
                                                        <form action="{{route('informes.autorizar',$inf->id_informe)}}" method="POST" role="form" id="form_materials">
                                                            @csrf
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="nombre_material">Solicitud</label>
                                                                    <p class="form-control">{{$inf->nombre_sol}} - {{$inf->zona_sol}} </p>
                                                                    <input type="hidden" name="informe_id" value="{{$inf->id_informe}}">
                                                                </div>
                                                                <input type="hidden" name="user_id" value={{$inf->user_id}}>
                                                                <div class="form-group col-md-6">
                                                                    <label for="fecha_inspe">Fecha programada de ejecución</label>
                                                                    <div class="input-group ">
                                                                        <div class="input-group-prepend">
                                                                        </div>
                                                                        <input class="form-control" id="fecha_inspe" name="fecha_programada" type="date" value="" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->
                                                            <div class="card-footer">
                                                                <button type="submit" class="btn btn-block btn-primary">Asignar</button>
                                                            </div>
                                                        </form>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
                        @endcan
                        @can('jefe-red')
                        @if($inf->estado=='registrado')
                            <a href='{{route('informes.no_autorizar',$inf->id_informe)}}'
                            class='d-inline btn btn-warning btn-icon btn-xs'>No Autorizar <i class="fas fa-pencil-alt"></i></a>
                        @endif
                        @endcan

                        @can('inspector')
                        @if($inf->estado=='registrado')
                        <a href='{{route('informes.edit',$inf->id_informe)}}'
                        class='d-inline btn btn-primary btn-icon btn-xs'>Editar <i class="fas fa-pencil-alt"></i></a>
                        @endif
                        @endcan
                        @if ($inf->estado =='firmado')
                        <a href='{{route('reportePDF.informe_material',$inf->id_informe)}}' target="_blank"
                            class='btn btn-danger btn-icon btn-xs'>Reporte ampliacion <i class="fas fa-box-open"></i></a>
                        @endif


                    </td>

                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>NRO</th>
                <th>ZONA O BARRIO</th>
                <th>NOMBRE SOLICITANTE</th>
                <th>FECHA <br>INSPECCION O EJECUCION PROGRAMADA</th>
                <th>ESTADO</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
    </table>

    <!-- Large modal -->


    <div class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow:hidden;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">LISTA DE MATERIALES</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="contenido" >
                      {{--  --}}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
    <script>
        $('.select2').select2();
        $.fn.modal.Constructor.prototype._enforceFocus = function() {};

        function llamar (url) {
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                if (ajax.readyState==4 && ajax.status==200) {
                    document.getElementById("contenido").innerHTML=ajax.responseText;
                }
            };
            ajax.open("GET",url,true);
            ajax.send();
        }

    </script>
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
