@php
setlocale(LC_TIME,"es_ES");
    $fecha=strtotime($solicitud->fecha_sol);
    $anio=date("Y",$fecha);
    $mes=date("M", $fecha);
    $dia=date("d", $fecha);
    setlocale(LC_TIME,"es_ES");

    $Mes_ = strftime("%B", strtotime($mes));
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INFORME RECHAZADO</title>
</head>

<style>
    p{
        padding: 10px;
        font-size: 16px;
    }
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

        <h3 class="centrar">INFORME DE SOLICITUD RECHAZADA</h3>
        <div align="center">
            <img src="{{asset('rechazadas/'.$solicitud->sol_rechazada)}}" width="680px" height="350px" alt="">
        </div>
        <p style="margin:5px 20px 5px 40px ">Estimado usuario <strong>{{$solicitud->nombre_sol}}</strong>, en respuesta a su solicitud realiazada el dia {{$dia}} de {{$Mes_}} de {{$anio}}  le imformamos que lamentablemente no se no se podrá realiazar la instalación de agua potable en su domicilio ubicado en la calle <strong>{{$solicitud->calle_sol}}</strong> zona <strong>{{$solicitud->zona_sol}}</strong> debido al siguiente mottivo: <br><br> {{$solicitud->observaciones}}
        </p>



<br><br>
<div class="firma">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    ..............................................
</div>
<div class="firma">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    FIRMA JEFE DE RED
</div>
</body>
</html>
