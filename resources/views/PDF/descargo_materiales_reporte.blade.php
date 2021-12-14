<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ampliacion tuberia matriz</title>
</head>
@php
    setlocale(LC_TIME, "spanish");
    $fecha=strtotime($informe->fecha_hora_in);
    $anio=date("Y",$fecha);
    $mes=date("M", $fecha);
    $dia=date("d", $fecha);
    setlocale(LC_TIME, "spanish");
	$pedido=10000+$informe->id;
    $Mes_ = strftime("%B", strtotime($mes));
    $n=1;
@endphp
<style>
    body{
        font-family:verdana;
    }
    .container{
        margin:0px 5px;
    }

    #contenedor{
        width: 680px;
        margin: 0 auto;
    }
    table,td{
        border: 1px solid black;
        border-collapse:collapse;

    }

    .centrar{
        text-align:center;
    }
    .borde{
        outline: 2px solid black;
    }
    .total{
        float: right;
        border: 1px dashed black;
        height: 21px;
        width: 83px;
        outline: 1px solid black;
    }
    .tamanio{
        font-size: 13px;
    }
</style>
<body>
    <div class="container" id="contenedor">
    <div>
        <h5 align="center">DESCARGO DE MATERIALES POR ADMINISTRACION DIRECTA</h5>
    </div>
    <div>
        <div style="background:; float:left;">
            <label class="tamanio">&nbsp;&nbsp;PARA USO: AMPLIACION RED DE AGUA</label><br>
            <label class="tamanio">&nbsp;&nbsp;ZONA: {{$inspector->zona_sol}} </label><br>
            <label class="tamanio">&nbsp;&nbsp;FECHA SOLICITUD: {{$inspector->fecha_sol}} </label><br>
            <label class="tamanio">&nbsp;&nbsp;LONGITUD AMPLIACION: {{$informe->longitud_in}}</label><br>
            <label class="tamanio">&nbsp;&nbsp;INSPECTOR: {{$inspector->nombre_inspector}}</label><br>
        </div>
        <div style="background:; float:right; ">
            <label class="tamanio">PEDIDO N°: {{$pedido}}</label><br>
            <label class="tamanio">CALLE: {{$inspector->calle_sol}} </label><br>
            <label class="tamanio">FECHA EJECUCION: {{$inspector->fecha_ejecutada}} </label><br>
            <label class="tamanio">DESPACHO</label>
        </div>
    </div>

    <div><br><br><br></div>

    <br><br><br>
    <div>
        <img src="{{asset('storage/'.$informe->imagen_amp)}}" width="680px" height="400px" alt="">


        <h5 style="text-align: center;">DESCARGO DE MATERIALES ELAPAS</h5>
        <table width="100%" >
            <tr>
                <td class="centrar">N°</td>
                <td class="centrar">DESCRIPCION DE MATERIAL</td>
                <td class="centrar">UNIDAD</td>
                <td class="centrar">CANTIDAD</td>
                <td class="centrar">P.UNITARIO</td>
                <td class="centrar">C.PARCIAL</td>
            </tr>
            @php
            $precio_total = 0.00;
            $n = 1;
            $costo_total = 0.00;
            @endphp
            @foreach ($materiales as $mat )
            @if ($mat->observador == 'Elapas')
            @php
                $sub_total = round($mat->cantidad * $mat->precio_unitario,2);
            @endphp
            <tr>
                <td class="centrar">{{$n++}}</td>
                <td >{{$mat->nombre_material}}</td>
                <td class="centrar tamanio">{{$mat->u_medida}}</td>
                <td class="centrar tamanio">{{$mat->cantidad}}</td>
                <td class="centrar tamanio">{{$mat->precio_unitario}}</td>
                <td class="centrar tamanio">{{$sub_total}}</td>
            </tr>
            @php
                $precio_total = $precio_total + $sub_total;
            @endphp
            @endif
            @endforeach
            @php
                $costo_total = $costo_total + $precio_total;
            @endphp
            <tr>
                <td style="border-bottom: hidden; border-left: hidden;"></td>
                <td style="border-bottom: hidden; border-left: hidden;"></td>
                <td colspan="3" style="text-align:right; border-bottom: 1px solid black"><b>COSTO TOTAL MATERIALES Bs.</b></td>
                <td style="text-align:center">{{round($precio_total,2)}}</td>
            </tr>
        </table>
    </div>
    <div>
        <h5 style="text-align: center;">APORTE DE MATERIALES VECINOS</h5>
        <table width="100%" >
            <tr>
                <td class="centrar">N°</td>
                <td class="centrar">DESCRIPCION DE MATERIAL</td>
                <td class="centrar">UNIDAD</td>
                <td class="centrar">CANTIDAD</td>
                <td class="centrar">P.UNITARIO</td>
                <td class="centrar">C.PARCIAL</td>
            </tr>
            @php
            $precio_total = 0.00;
            $n = 1;
            @endphp
            @foreach ($materiales as $mat )
            @if ($mat->observador == 'Vecinos')
            @php
                $sub_total = round($mat->cantidad * $mat->precio_unitario,2);
            @endphp
            <tr>
                <td class="centrar">{{$n++}}</td>
                <td >{{$mat->nombre_material}}</td>
                <td class="centrar tamanio">{{$mat->u_medida}}</td>
                <td class="centrar tamanio">{{$mat->cantidad}}</td>
                <td class="centrar tamanio">{{$mat->precio_unitario}}</td>
                <td class="centrar tamanio">{{$sub_total}}</td>
            </tr>
            @php
                $precio_total = $precio_total + $sub_total;
            @endphp
            @endif
            @endforeach
            @php
            $costo_total = $costo_total + $precio_total;
            @endphp
            <tr>
                <td style="border-bottom: hidden; border-left: hidden;"></td>
                <td style="border-bottom: hidden; border-left: hidden;"></td>
                <td colspan="3" style="text-align:right; border-bottom: 1px solid black"><b>COSTO TOTAL MATERIALES Bs.</b></td>
                <td style="text-align:center">{{round($precio_total,2)}}</td>
            </tr>
        </table>
    </div>
    <div>
       <h5 style="text-align: center;">CUADRO DE COMPUTOS METRICOS ELAPAS</h5>
        <table width="100%" >
            <tr>
                <td class="centrar">N°</td>
                <td class="centrar">ACTIVIDAD</td>
                <td class="centrar">ANCHO</td>
                <td class="centrar">ALTO</td>
                <td class="centrar">LARGO</td>
                <td class="centrar">VOLUMEN</td>
            </tr>
            @php
            $precio_total = 0.00;
            $n = 1;
            @endphp
            @foreach ($mano_obra as $mano )
            @if ($mano->observador == 'Elapas')
            @php
                $sub_total = round($mano->ancho * $mano->alto * $mano->largo,2);
            @endphp
            <tr>
                <td class="centrar">{{$n++}}</td>
                <td >{{$mano->descripcion}}</td>
                <td class="centrar tamanio">{{$mano->ancho}}</td>
                <td class="centrar tamanio">{{$mano->alto}}</td>
                <td class="centrar tamanio">{{$mano->largo}}</td>
                <td class="centrar tamanio">{{$sub_total}}</td>
            </tr>
            @endif
            @endforeach

        </table>
    </div>
    <div>
        <h5 style="text-align: center;">CUADRO DE COMPUTOS METRICOS VECINOS</h5>
        <table width="100%" >
            <tr>
                <td class="centrar">N°</td>
                <td class="centrar">ACTIVIDAD</td>
                <td class="centrar">ANCHO</td>
                <td class="centrar">ALTO</td>
                <td class="centrar">LARGO</td>
                <td class="centrar">VOLUMEN</td>
            </tr>
            @php
            $precio_total = 0.00;
            $n = 1;
            @endphp
            @foreach ($mano_obra as $mano )
            @if ($mano->observador == 'Vecinos')
            @php
                $sub_total = round($mano->ancho * $mano->largo * $mano->alto,2);
            @endphp
            <tr>
                <td class="centrar">{{$n++}}</td>
                <td >{{$mano->descripcion}}</td>
                <td class="centrar tamanio">{{$mano->ancho}}</td>
                <td class="centrar tamanio">{{$mano->alto}}</td>
                <td class="centrar tamanio">{{$mano->largo}}</td>
                <td class="centrar tamanio">{{$sub_total}}</td>
            </tr>
            @endif
            @endforeach

        </table>
    </div>
    <div>
        <h5 style="text-align: center;">APORTE PARA EXCAVACIÓN Y TENDIDO ELAPAS</h5>
        <table width="100%" >
            <tr>
                <td class="centrar">N°</td>
                <td class="centrar">DESCRIPCION</td>
                <td class="centrar">UNIDAD</td>
                <td class="centrar">CANTIDAD</td>
                <td class="centrar">P.UNITARIO</td>
                <td class="centrar">C.PARCIAL</td>
            </tr>
            @php
            $precio_total = 0.00;
            $n = 1;
            @endphp
            @foreach ($mano_obra as $mat )
            @if ($mat->observador == 'Elapas')
            @php
                $sub_total = round($mat->cantidad * $mat->precio_unitario,2);
            @endphp
            <tr>
                <td class="centrar">{{$n++}}</td>
                <td >{{$mat->descripcion}}</td>
                <td class="centrar tamanio">{{$mat->unidad}}</td>
                <td class="centrar tamanio">{{$mat->cantidad}}</td>
                <td class="centrar tamanio">{{$mat->precio_unitario}}</td>
                <td class="centrar tamanio">{{$sub_total}}</td>
            </tr>
            @php
                $precio_total = $precio_total + $sub_total;
            @endphp
            @endif
            @endforeach
            @php
            $costo_total = $costo_total + $precio_total;
            @endphp
            <tr>
                <td style="border-bottom: hidden; border-left: hidden;"></td>
                <td style="border-bottom: hidden; border-left: hidden;"></td>
                <td colspan="3" style="text-align:right; border-bottom: 1px solid black"><b>C. TOTAL</b></td>
                <td style="text-align:center">{{round($precio_total,2)}}</td>
            </tr>
        </table>

    </div>
    <div>
        <h5 style="text-align: center;">APORTE PARA EXCAVACIÓN Y TENDIDO VECINOS</h5>
        <table width="100%" >
            <tr>
                <td class="centrar">N°</td>
                <td class="centrar">DESCRIPCION</td>
                <td class="centrar">UNIDAD</td>
                <td class="centrar">CANTIDAD</td>
                <td class="centrar">P.UNITARIO</td>
                <td class="centrar">C.PARCIAL</td>
            </tr>
            @php
            $precio_total = 0.00;
            $n = 1;
            @endphp
            @foreach ($mano_obra as $mat )
            @if ($mat->observador == 'Vecinos')
            @php
                $sub_total = round($mat->cantidad * $mat->precio_unitario,2);
            @endphp
            <tr>
                <td class="centrar">{{$n++}}</td>
                <td >{{$mat->descripcion}}</td>
                <td class="centrar tamanio">{{$mat->unidad}}</td>
                <td class="centrar tamanio">{{$mat->cantidad}}</td>
                <td class="centrar tamanio">{{$mat->precio_unitario}}</td>
                <td class="centrar tamanio">{{$sub_total}}</td>
            </tr>
            @php
                $precio_total = $precio_total + $sub_total;
            @endphp
            @endif
            @endforeach
            @php
            $costo_total = $costo_total + $precio_total;
            @endphp
            <tr>
                <td style="border-bottom: hidden; border-left: hidden;"></td>
                <td style="border-bottom: hidden; border-left: hidden;"></td>
                <td colspan="3" style="text-align:right; border-bottom: 1px solid black"><b>C. TOTAL</b></td>
                <td style="text-align:center">{{round($precio_total,2)}}</td>
            </tr>
        </table>
        <br>
        <table align="right">
            <tr>
                <td> <b>COSTO TOTAL DEL PROYECTO Bs.</b> </td>
                <td class="centrar" width="125px">{{$costo_total}}</td>
            </tr>
        </table>

    </div>
    <div><br><br>
        {{$inspector->nombre_inspector}}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


    </div>
    <div style="height:25px;">
        {{-- <div style="background-color:red; width: 1 fr;"float="left">{{$inspector->nombre_inspector}} <br> INSPECTOR</div>
        <div style="background-color:blue; width: 1 fr"float="left"><br> JEFE DE DIVISION</div>
        <div style="background-color:yellow; width: 1 fr"float="left"><br>ACTIVOS FIJOS</div> --}}
        INSPECTOR
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        JEFE DE DIVISION
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        ACTIVOS FIJOS
    </div>

</div>
</div>
</body>
</html>
