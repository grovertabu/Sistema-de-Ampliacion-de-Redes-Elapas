@php
    $meses = array(
        "1"=>"Enero",
        "2"=>"Febrero",
        "3"=>"Marzo",
        "4"=>"Abril",
        "5"=>"Mayo",
        "6"=>"Junio",
        "7"=>"Julio",
        "8"=>"Agosto",
        "9"=>"Septiembre",
        "10"=>"Octubre",
        "11"=>"Noviembre",
        "12"=>"Diciembre"
    );
    setlocale(LC_TIME, "spanish");
    $fecha=strtotime($informe->fecha_hora_in);
    $anio=date("Y",$fecha);
    $mes=date("m", $fecha);
    $dia=date("d", $fecha);
    setlocale(LC_TIME, "spanish");

    $Mes_ = $meses[$mes];

    setlocale(LC_TIME, "spanish");
    $fecha_sol=strtotime($informe->solicitud->fecha_sol);
    $anio_sol=date("Y",$fecha_sol);
    $mes_sol=date("m", $fecha_sol);
    $dia_sol=date("d", $fecha_sol);
    setlocale(LC_TIME, "spanish");

    $Mes_sol = $meses[$mes_sol];
    $n =1;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INFORME PROYECTO</title>
</head>

<style>
    th{
        padding: 10px;
    }
    table,td{
        border: 1px solid black;
        border-collapse:collapse;
    }
    #contenedor{
        width: 680px;
        margin: 0 auto;
    }
    table, td{
      border: 1px solid black;
      width: 100%;
      padding: 5px;
    }

    #table1{
      border-collapse: collapse;
      border-spacing: 10px;
    }
    .centrar{
        text-align: center;
    }
    div.firma{
        padding-left: 60px;
    }
    div.firma2{
        text-align: right;
    }

    .tabla_materiales,td{
        border: 1px solid black;
        border-collapse:collapse;
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
    <div id="contenedor">

    <h2 style="text-align: center">PROYECTO DE AMPLIACION</h2>
<table id="table1">
    <tr>
        <td colspan="4"><strong>NOMBRE Y APELLIDO:</strong>  {{$informe->solicitud->nombre_sol}}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>CALLE:</strong>  {{$informe->solicitud->calle_sol}}</td>
        <td colspan="2"><strong>ZONA:</strong>{{$informe->solicitud->zona_sol}}</td>
    </tr>
    <tr>
        <td class="centrar" rowspan="2"><strong>FECHA DE SOLICITUD</strong></td>
        <th class="centrar">AÑ0</th>
        <th class="centrar">MES</th>
        <th class="centrar">DIA</th>

    </tr>
    <tr>
        <td class="centrar">{{$anio_sol}}</td>
        <td class="centrar">{{$Mes_sol}}</td>
        <td class="centrar">{{$dia_sol}}</td>
    </tr>

    <tr>
        <td colspan="4" class="centrar">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/'.$informe->imagen_amp))) }}" width="680px" height="350px" alt="">

        </td>
    </tr>

    <tr>
        <td colspan="4"><strong> Nombre del Inspector : </strong> {{$inspector->nombre}}</td>
    </tr>
    <tr>
        <td class="centrar" rowspan="2"><strong>FECHA DE INSPECCION</strong></td>
        <th class="centrar">AÑ0</th>
        <th class="centrar">MES</th>
        <th class="centrar">DIA</th>

    </tr>
    <tr>
        <td class="centrar">{{$anio}}</td>
        <td class="centrar">{{$Mes_}}</td>
        <td class="centrar">{{$dia}}</td>
    </tr>
    <tr>
        <td class="centrar" colspan="2"> <strong>  CONDICIONES DE RASANTE </strong> </td>
        <td class="centrar">{{$informe->condicion_rasante=='BUENA'?'BUENA':''}}</td>
        <td class="centrar">{{$informe->condicion_rasante=='MALA'?'MALA':''}}</td>

    </tr>
    <tr>
        <td class="centrar" colspan="2" ><strong>ESPECIFICAR EL AREA DE CONCESION</strong></td>
        <td class="centrar">{{$informe->espesifiar_in=='Si'?'SI':''}}</td>
        <td class="centrar">{{$informe->espesifiar_in=='No'?'NO':''}}</td>

    </tr>
</table>

<div><br>
    <table width="100%" class="tabla_materiales">
        <tr>
            <td colspan="7">A. MATERIALES</td>
        </tr>
        <tr>
            <td class="centrar">N°</td>
            <td class="centrar">DESCRIPCION</td>
            <td class="centrar">UNIDAD</td>
            <td class="centrar">CANTIDAD</td>
            <td class="centrar">OBSERVACION</td>
            <td class="centrar">P.UNITARIO</td>
            <td class="centrar">P.TOTAL</td>
        </tr>
        @php
            $precio_total = 0.00;
            $costo_total = 0.00;
        @endphp
        @foreach ($materiales as $material )
        @php
            $sub_total = round($material->cantidad * $material->precio_unitario,2);
        @endphp
        <tr>
            <td class="centrar">{{$n++}}</td>
            <td >{{$material->nombre_material}}</td>
            <td class="centrar tamanio">{{$material->u_medida}}</td>
            <td class="centrar tamanio">{{$material->cantidad}}</td>
            <td class="centrar tamanio">{{$material->observador}}</td>
            <td class="centrar tamanio">{{$material->precio_unitario}}</td>
            <td class="centrar tamanio">{{$sub_total}}</td>
        </tr>
        @php
            $precio_total = $precio_total + $sub_total;
        @endphp
        @endforeach
    </table>
    @php
        $costo_total = $costo_total + $precio_total;
    @endphp
    <div class="centrar total" >{{$precio_total}} Bs.</div>

    <br><br>

    <table width="100%" class="tabla_materiales">
        <tr>
            <td colspan="7">B. MANO DE OBRA</td>
        </tr>
        <tr>
            <td class="centrar">N°</td>
            <td class="centrar">DESCRIPCION</td>
            <td class="centrar">UNIDAD</td>
            <td class="centrar">CANTIDAD</td>
            <td class="centrar">OBSERVACION</td>
            <td class="centrar">P.UNITARIO</td>
            <td class="centrar">P.TOTAL</td>
        </tr>
        @php
        $precio_total = 0.00;
        $n = 1;
        @endphp
        @foreach ($mano_obra as $mano )
        @php
            $sub_total = round($mano->cantidad * $mano->precio_unitario,2);
        @endphp
        <tr>
            <td class="centrar">{{$n++}}</td>
            <td >{{$mano->descripcion}}</td>
            <td class="centrar tamanio">{{$mano->unidad}}</td>
            <td class="centrar tamanio">{{$mano->cantidad}}</td>
            <td class="centrar tamanio">{{$mano->observador}}</td>
            <td class="centrar tamanio">{{$mano->precio_unitario}}</td>
            <td class="centrar tamanio">{{$sub_total}}</td>
        </tr>
        @php
            $precio_total = $precio_total + $sub_total;
        @endphp
        @endforeach

    </table>
    <div class="centrar total" >{{$precio_total}} Bs.</div>
</div>
@php
$costo_total = $costo_total + $precio_total;
@endphp
<br><br>
<table align="right">
    <tr>
        <td> <b>COSTO TOTAL DEL PROYECTO Bs.</b> </td>
        <td class="centrar" width="125px">{{$costo_total}}</td>
    </tr>
</table>
<br>
<br>
<p style="text-align:left; margin-left:10px">
    El proyecto de ampliación de red ha sido aprobado y generado para la solicitud N° <b>{{$informe->solicitud_id.'/'.date('Y')}}</b>
    de fecha <b> {{$dia_sol. ' de '. $Mes_sol. ' del '.$anio_sol}}</b> y contará con una ampliación de <b>{{$informe->longitud_in}}</b> metros que
    beneficiará a un total de {{$informe->num_flia_in}} familias
</p>
<br><br><br>
<div style="text-align:center">

    ............................................
</div>
<div style="text-align:center">

    PROYECTISTA
</div>
</div>
</body>
</html>
