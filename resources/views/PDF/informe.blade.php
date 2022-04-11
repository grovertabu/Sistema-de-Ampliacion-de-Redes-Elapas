@php
    setlocale(LC_TIME, "spanish");
    $fecha=strtotime($informe->fecha_hora_in);
    $anio=date("Y",$fecha);
    $mes=date("m", $fecha);
    $dia=date("d", $fecha);
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

    $Mes_ = $meses[intval($mes)];
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
    .botones{
        width: 700px;
        margin: 0 auto;
    }
    button{
        width: 100%;
        background-color:#dc3545;
        height: 40px;
        font-size: 20px;
        color: white;
    }
    #contenedor{
        width: 680px;
        margin: 0 auto;
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
        text-align: center;
    }
    div.firma2{
        text-align: right;
    }

    </style>
<body>
        <div id="contenedor">
            <table id="table1">
                <tr >
                    <th colspan="4">TRAMITE DE INSTALACIONES</th>
                </tr>
                <tr>
                    <td colspan="4"><strong>NOMBRE Y APELLIDO:</strong>  {{$informe->solicitud->nombre_sol}}</td>
                </tr>
                <tr>
                    <td colspan="4"><strong>CALLE:</strong>  {{$informe->solicitud->calle_sol}}</td>
                </tr>
                <tr>
                    <td colspan="4"><strong>ZONA:</strong>{{$informe->solicitud->zona_sol}}</td>
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
                    <td class="centrar" colspan="2" ><strong>ESPECIFICAR EL AREA DE CONCESION</strong></td>
                    <td class="centrar">{{$informe->espesifiar_in=='Si'?'SI':''}}</td>
                    <td class="centrar">{{$informe->espesifiar_in=='No'?'NO':''}}</td>

                </tr>
                <tr>
                    <td  colspan="4">
                        @if($informe->imagen_amp == null)
                        <img src="https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11/static/pin-s+FF0000({{$informe->solicitud->y_aprox}},{{$informe->solicitud->x_aprox}})/{{$informe->solicitud->y_aprox}},{{$informe->solicitud->x_aprox}},17/680x400?access_token=pk.eyJ1IjoiZ3JvdmVydDEyIiwiYSI6ImNrbnExMm1kZjAxbTEycXFxdWJlM2QyOWoifQ._OTf1cgFjXutCJPx2zMl1w" >
                        @else
                        <img src="{{asset('storage/'.$informe->imagen_amp)}}" width="680px" height="400px" alt="">
                        @endif
                        {{-- <img src="https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11/static/geojson(%7B%22type%22%3A%22FeatureCollection%22%2C%22features%22%3A%5B%7B%22type%22%3A%22Feature%22%2C%22properties%22%3A%7B%22stroke%22%3A%22red%22%2C%22stroke-width%22%3A6%2C%22stroke-opacity%22%3A1%7D%2C%22geometry%22%3A%7B%22type%22%3A%22LineString%22%2C%22coordinates%22%3A%5B%5B-65.25664865970612%2C-19.02013081578586%5D%2C%5B-65.25647699832916%2C-19.019983740975054%5D%5D%7D%7D%5D%7D)/-65.25674,-19.02012,17/680x400?access_token=pk.eyJ1IjoiZ3JvdmVydDEyIiwiYSI6ImNrbnExMm1kZjAxbTEycXFxdWJlM2QyOWoifQ._OTf1cgFjXutCJPx2zMl1w" > --}}

                    </td>
                </tr>
                <tr>
                    <td class="centrar" colspan="2" rowspan="2">COORDENADAS GEOGRAFICAS</td>
                    <td class="centrar">LATITUD</td>
                    <td class="centrar">LONGITUD</td>

                </tr>
                <tr>
                    <td class="centrar">{{isset($informe->x_exact)?$informe->x_exact:'....'}}</td>
                    <td class="centrar">{{isset($informe->y_exact)?$informe->y_exact:'....'}}</td>
                </tr>
                <tr>
                    <td class="centrar" colspan="2">UBICACION GEOREFERENCIAL</td>
                    <td class="" colspan="2"><a href="{{isset($informe->ubicacion_geo)?$informe->ubicacion_geo:'#'}}">{{isset($informe->ubicacion_geo)?$informe->ubicacion_geo:'....'}}</a></td>
                </tr>
                <tr>
                    <td colspan="4">LONGITUD DE LA AMPLIACION: {{isset($informe->longitud_in)?$informe->longitud_in:'....'}} metros</td>
                </tr>
                <tr>
                    <td colspan="2">NUMERO DE BENEFICIARIOS:</td>
                    <td>Nº:{{isset($informe->num_ben_in)?$informe->num_ben_in:'....'}}</td>
                    <td>Flia.:{{isset($informe->num_flia_in)?$informe->num_flia_in:'....'}}</td>
                </tr>
                <tr>
                    <td colspan="4">DIAMETRO DE LA AMPLIACION:{{isset($informe->diametro_in)?$informe->diametro_in:''}}</td>
                </tr>
                <tr>
                    <td class="centrar" colspan="2">CONDICIONES DE RASANTE</td>
                    <td class="centrar">{{$informe->condicion_rasante=='BUENA'?'BUENA':''}}</td>
                    <td class="centrar">{{$informe->condicion_rasante=='MALA'?'MALA':''}}</td>

                </tr>
            </table>
            <br><br><br>
            <div class="firma">............................................     ......................................
            </div>
            <div class="firma">FIRMA DEL INSPECTOR

                &nbsp;&nbsp;&nbsp;&nbsp;                       FIRMA JEFE DE RED
            </div>

        </div>
</body>
</html>
