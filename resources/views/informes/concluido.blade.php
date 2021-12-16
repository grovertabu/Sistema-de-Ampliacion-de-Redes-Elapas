@extends('adminlte::page')

@section('title', 'Concluidos')

@section('content_header')
@php
    $n = 0;
@endphp
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
            <th>FECHA <br>EJECUCION</th>
            <th>ESTADO</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($informes as $inf)
            @php
                $n++;
            @endphp
                <tr>
                    <td>{{'S-'.$inf->id_solicitud}}</td>
                    <td>{{$inf->zona_sol}}</td>
                    <td>{{$inf->nombre_sol}}</td>
                    <td>@php   echo $inf->fecha_ejecutada == null ? "Sin Fecha Programda" : $inf->fecha_ejecutada @endphp</td>


                    <td align="center"><span class="badge badge-primary">{{$inf->estado}}</span></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$n}}">
                            <i class="fa fa-file"></i>
                          </button>

                          <div class="modal fade" id="exampleModal{{$n}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Informes</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body" style="text-align: center;">
                                    @can('jefe-red')
                                    <p>
                                        <a type="button" onclick="mostrarPDF('{{route('solicitud.escaneada',$inf->id_solicitud)}}')"  class=" text-white btn btn-danger btn-icon w-75">
                                           Solicitud Escaneada <i class="fa fa-file-pdf"></i>
                                        </a>
                                    </p>
                                    @endcan
                                    <p>
                                        <a onclick="mostrarPDF('{{route('descargarPDF.informe',$inf->id_informe)}}')" target="_blank"
                                            class='text-white btn btn-danger btn-icon w-75'>Informe de Inspección <i class="fas fa-file-pdf"></i></a>

                                    </p>
                                    <p>
                                        <a onclick="mostrarPDF('{{route('pedidoPDF.informe',$inf->id_informe)}}')" target="_blank"
                                        class='text-white btn btn-danger btn-icon w-75'>Pedido de Material <i class="fas fa-file-pdf"></i></a>

                                    </p>
                                    <p>
                                        <a onclick="mostrarPDF('{{route('reportePDF.informe_material',$inf->id_informe)}}')" target="_blank"
                                            class='text-white btn btn-danger btn-icon w-75'>Informe de Ampliacion <i class="fas fa-file-pdf"></i></a>

                                    </p>
                                    <p>
                                        <a onclick="mostrarPDF('{{route('descargarPDF.proyecto',$inf->id_informe)}}')" target="_blank"
                                            class="text-white btn btn-danger btn-icon w-75">Informe de Proyección <i class="fas fa-file-pdf"></i></a>

                                    </p>
                                    @if($inf->estado == 'ejecutado')
                                    <p>
                                        <a onclick="mostrarPDF('{{route('reportePDF.informe_descargo_material',$inf->id_informe)}}')" target="_blank"
                                            class='text-white btn btn-danger btn-icon w-75'>Informe de Ejecución de Proyecto<i class="fas fa-file-pdf"></i></a>

                                    </p>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          @can('inspector')
                          @if($inf->estado== "ejecutandose")
                          <button type="button" class='btn btn-success btn-icon' data-toggle="modal" data-target=".bd-example-modal-lg{{$inf->id_ejecucion}}"
                              onclick="" title="Generar Informes"><i class="fas fa-file-signature"></i></button>
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
                                          <div class="modal-body" >
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
                                                              <input type="hidden" name="id_informe" value="{{$inf->id_informe}}">
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
                                                              <button type="submit" class="btn btn-block btn-primary">Enviar</button>
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


                    </td>

                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>NRO</th>
                <th>ZONA O BARRIO</th>
                <th>NOMBRE SOLICITANTE</th>
                <th>FECHA <br>EJECUCION</th>
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
    <script src="{{asset('js/informes.js')}}"></script>
@stop
@section('css')
    <style>
        @media print {
            @page { margin: 0; }
            body { margin: 1.6cm; }
        }
    </style>
@stop
