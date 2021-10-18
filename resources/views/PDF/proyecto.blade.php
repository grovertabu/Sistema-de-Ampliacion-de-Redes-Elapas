@php
    setlocale(LC_TIME, "spanish");
    $fecha=strtotime($informe->fecha_hora_in);
    $anio=date("Y",$fecha);
    $mes=date("M", $fecha);
    $dia=date("d", $fecha);
    setlocale(LC_TIME, "spanish");

    $Mes_ = strftime("%B", strtotime($mes));

    setlocale(LC_TIME, "spanish");
    $fecha_sol=strtotime($informe->solicitud->fecha_sol);
    $anio_sol=date("Y",$fecha_sol);
    $mes_sol=date("M", $fecha_sol);
    $dia_sol=date("d", $fecha_sol);
    setlocale(LC_TIME, "spanish");

    $Mes_sol = strftime("%B", strtotime($mes_sol));

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
        <td class="centrar" colspan="2" ><strong>ESPESIFIAR EL AREA DE CONCESION</strong></td>
        <td class="centrar">{{$informe->espesifiar_in=='Si'?'SI':''}}</td>
        <td class="centrar">{{$informe->espesifiar_in=='No'?'NO':''}}</td>

    </tr>
</table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
               function convertirPDF(){
            const element = document.querySelector('#contenedor');
            var opt = {
                margin:       0.5,
                filename:     'informe.pdf',
                image:        { type: 'jpeg', quality: 0.98},
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'legal', orientation: 'p' }
            };
            html2pdf().set(opt).from(element).outputPdf().then(function(pdf) {
                pdf = btoa(pdf);
                console.log(pdf.length)
                var obj = document.createElement('object');
                obj.style.width = '100%';
                obj.style.height = window.screen.height + 'px';
                obj.style.margin = '-10px'
                obj.style.position = 'absolute'
                obj.type = 'application/pdf';
                obj.data = 'data:application/pdf;base64,' + pdf;
                element.style.display = 'none';
                document.body.appendChild(obj);

            });
           }
           window.onload = function(){
               convertirPDF();
           }
</script>
</body>
</html>
