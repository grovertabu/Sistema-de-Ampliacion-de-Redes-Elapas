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
    <div class="container">
    <div>
        <h1 align="center">Ampliación Tuberia Matriz 2" Barrio {{$informe->solicitud->zona_sol}}</h1>
    </div>
    <div style=" width:690px; height:400px;">
        <img src="https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11/static/pin-s+FF0000({{$informe->solicitud->y_aprox}},{{$informe->solicitud->x_aprox}})/{{$informe->solicitud->y_aprox}},{{$informe->solicitud->x_aprox}},17/700x380?access_token=pk.eyJ1IjoiZ3JvdmVydDEyIiwiYSI6ImNrbnExMm1kZjAxbTEycXFxdWJlM2QyOWoifQ._OTf1cgFjXutCJPx2zMl1w" >
        
    </div>
    <div>
        <div style="background:; float:left; width:750px;">
            <label class="tamanio">&nbsp;&nbsp;OBRA: Ampliacion</label><br>
            <label class="tamanio">&nbsp;&nbsp;CALLE: {{$informe->solicitud->calle_sol}} </label><br>
            <label class="tamanio">&nbsp;&nbsp;FECHA: {{ucfirst($Mes_)}}</label> 
        </div>
        <div style="background:; float:right; width:300px;">
            <label class="tamanio">RESERVORIO: {{$informe->reservorio}}</label><br>
            <label class="tamanio">PEDIDO N°: {{"0".$pedido}}</label><br>
            <label class="tamanio">DESPACHO</label>
        </div>
    </div>
    
    <div><br><br><br>
    <table width="100%" >
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
        @foreach ($materiales as $material )
        <tr>
            <td class="centrar">{{$n++}}</td>
            <td >{{$material->nombre_material}}</td>
            <td class="centrar tamanio">{{$material->u_medida}}</td>
            <td class="centrar tamanio">{{$material->cantidad}}</td>
            <td class="centrar tamanio"></td>
            <td class="centrar tamanio"></td>
            <td class="centrar tamanio"></td>
        </tr>
        @endforeach
        <tr>
            <td class="centrar">-</td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
        </tr>
        <tr>
            <td class="centrar">-</td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
        </tr>
        <tr>
            <td class="centrar">-</td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
        </tr>
        <tr>
            <td class="centrar">-</td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
            <td class="centrar"></td>
        </tr>
    </table>
    <div class="total" ></div>

    <br><br>

    <table width="100%" >
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
       
        <tr>
            <td class="centrar">1</td>
            <td class="tamanio">TENDIDO de 2"</td>
            <td class="centrar tamanio">{{$mano_obra->u_medida}}</td>
            <td class="centrar tamanio">{{$mano_obra->cantidad}}</td>
            <td></td>
            <td></td>
            <td>ELAPAS</td>
        </tr>

        <tr>
            <td class="centrar">2</td>
            <td class="tamanio">EXCABACION TERRENO</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Vecinos</td>
        </tr>
        <tr>
            <td class="centrar">3</td>
            <td class="tamanio">TAPADO DE SANJA</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Vecinos</td>
        </tr>
    </table>
    <div class="total" ></div>
</div>
    <div><br><br>
        @foreach ($inspector as $i )
        <p align="center">{{$i->nombre_inspector}} <br> INSPECTOR</p>
        @endforeach
    </div>
    </div>
</body>
</html>