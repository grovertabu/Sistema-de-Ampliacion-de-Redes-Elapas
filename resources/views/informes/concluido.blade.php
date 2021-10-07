@extends('adminlte::page')

@section('title', 'Autorizacio')
@php
    $n=1;
@endphp
@section('content_header')
@stop

@section('content')
    <h1>ELAPAS - Informes Concluidos
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
            <th>FECHA <br>INSPECCION</th>
            <th>ESTADO</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($informes as $inf)
                <tr>
                    <td>{{$n++}}</td>
                    <td>{{$inf->zona_sol}}</td>
                    <td>{{$inf->nombre_sol}}</td>
                    <td>{{$inf->fecha_inspeccion}}</td>
                    <td align="center"><span class="badge badge-primary">{{$inf->estado}}</span></td>
                    <td>
                        @if ($inf->estado == 'firmado')
                            
                        @can('jefe-red')
                        <button type="button" class='btn btn-primary btn-icon btn-xs' data-toggle="modal" data-target=".bd-example-modal-lg{{$inf->id_informe}}"
                            onclick="">Asignar Inspector <i class="fas fa-user-plus"></i></button>
                            <!-- Large modal -->
                           <div class="modal fade bd-example-modal-lg{{$inf->id_informe}}" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow:hidden;">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Inspectores</h5>
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
                                                        <h3 class="card-title">Asignar Inspector</h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- formulario inicio -->
                                                    <form action="{{route('ejecucion.store')}}" method="POST" role="form" id="form_materials">
                                                        @csrf
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="nombre_material">Solicitud</label>
                                                                <p class="form-control">{{$inf->nombre_sol}}</p>
                                                                <input type="hidden" name="informe_id" value="{{$inf->id_informe}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nombre_material">Nombre del Inspector</label>
                                                                <select class="form-control  select2" name="user_id" id="user_id">
                                                                    <option selected>---Seleccione Inspector---</option>
                                                                    @foreach ($inspectores as $inspector )
                                                                        <option  value="{{$inspector->id}}">{{$inspector->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="fecha_inspe">Fecha de inspeccion</label>
                                                                <div class="input-group ">
                                                                    <div class="input-group-prepend">
                                                                    </div>
                                                                    <input class="form-control" id="fecha_inspe" name="fecha_programada" type="date" value="">
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
          
                            @endcan


                            @endif

                            <a href='{{route('descargarPDF.informe',$inf->id_informe)}}' target="_blank" 
                                class='btn btn-danger btn-icon btn-xs'>Informe <i class="fas fa-file-pdf"></i></a>

                                                            
                                @if($inf->estado!='registrado')
                                    <a href='{{route('pedidoPDF.informe',$inf->id_informe)}}' target="_blank" 
                                    class='btn btn-danger btn-icon btn-xs'>Reporte de pedido <i class="fas fa-box-open"></i></a>
                                @endif

                        
                        
                        @if($inf->estado=='ejecutado')
                            
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
                <th>FECHA <br>INSPECCION</th>
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