@php
    $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    $fecha=strtotime($solicitud->fecha_sol);
    $anio=date("Y",$fecha);
    $mes=date("M", $fecha);
    $dia=date("d", $fecha);
    setlocale(LC_TIME, "spanish");
			
    $Mes_ = strftime("%B", strtotime($mes));    
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
    <title>INFORME</title>
</head>

<style>
    th{
        padding: 10px;
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

    </style>
<body>
<table id="table1">
    <tr >
        <th colspan="4">INFORME DE SOLICITUD RECHAZADA</th>
    </tr>
    <tr>
        <td colspan="4"><strong>NOMBRE Y APELLIDO:</strong> {{$solicitud->nombre_sol}}</td>
    </tr>
    <tr>
        <td colspan="4"><strong>CALLE:</strong> {{$solicitud->calle_sol}}</td>
    </tr>
    <tr>
        <td colspan="4"><strong>ZONA:</strong> {{$solicitud->zona_sol}}</td>
    </tr>
    <tr>
        <td class="centrar" rowspan="2"><strong>FECHA DE SOLICITUD</strong></td>
        <th class="centrar">AÑO</th>
        <th class="centrar">MES</th>
        <th class="centrar">DIA</th>
      
    </tr>
    <tr>
        <td>{{$anio}}</td>
        <td>{{$Mes_}}</td>
        <td>{{$dia}}</td>
    </tr>
    <tr>
        <td colspan="4" class="centrar">
        <img src="https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11/static/pin-s+FF0000({{$solicitud->y_aprox}},{{$solicitud->x_aprox}})/{{$solicitud->y_aprox}},{{$solicitud->x_aprox}},17/680x400?access_token=pk.eyJ1IjoiZ3JvdmVydDEyIiwiYSI6ImNrbnExMm1kZjAxbTEycXFxdWJlM2QyOWoifQ._OTf1cgFjXutCJPx2zMl1w" >
        </td>
    </tr>
    <tr>
        <td colspan="4" >
            <strong>Observaciones: </strong> {{$solicitud->observaciones}}
        </td>
    </tr>

    
    
</table>
<br><br><br>
<div class="firma">............................................
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    ......................................
</div>
<div class="firma">FIRMA DEL INSPECTOR
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    FIRMA JEFE DE RED
</div>
</body>
</html>