@extends('adminlte::page')

@section('title', 'Concluidos')
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
            <th>FECHA <br>EJECUCION</th>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$n}}">
                            informes <i class="fa fa-file"></i>
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
                                    <p>
                                        <a href='{{route('descargarPDF.informe',$inf->id_informe)}}' target="_blank"
                                            class='btn btn-danger btn-icon w-75'>Informe <i class="fas fa-file-pdf"></i></a>

                                    </p>
                                    <p>
                                        <a href='{{route('pedidoPDF.informe',$inf->id_informe)}}' target="_blank"
                                        class='btn btn-danger btn-icon w-75'>Reporte de pedido <i class="fas fa-box-open"></i></a>

                                    </p>
                                    <p>
                                        <a href='{{route('reportePDF.informe_material',$inf->id_informe)}}' target="_blank"
                                            class='btn btn-danger btn-icon w-75'>Informe Ampliacion <i class="fas fa-file-pdf"></i></a>

                                    </p>
                                    <p>
                                        <a href='{{route('reportePDF.informe_descargo_material',$inf->id_informe)}}' target="_blank"
                                            class='btn btn-danger btn-icon w-75'>Informe Descargo Material <i class="fas fa-box-open"></i></a>

                                    </p>
                                    <p>
                                        <a href="{{route('descargarPDF.proyecto',$inf->id_informe)}}" target="_blank"
                                            class="btn btn-danger btn-icon w-75">Informe Proyeccion <i class="fas fa-file-pdf"></i></a>

                                    </p>




                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                              </div>
                            </div>
                          </div>



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
@stop
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
