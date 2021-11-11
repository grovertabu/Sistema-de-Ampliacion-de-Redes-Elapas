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
        <h1 align="center">Ampliación Tuberia Matriz 2" Barrio {{$informe->solicitud->zona_sol}}</h1>
    </div>
    <div style=" width:690px; height:400px;">
        {{-- <img src="https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11/static/pin-s+FF0000({{$informe->solicitud->y_aprox}},{{$informe->solicitud->x_aprox}})/{{$informe->solicitud->y_aprox}},{{$informe->solicitud->x_aprox}},17/700x380?access_token=pk.eyJ1IjoiZ3JvdmVydDEyIiwiYSI6ImNrbnExMm1kZjAxbTEycXFxdWJlM2QyOWoifQ._OTf1cgFjXutCJPx2zMl1w" > --}}
        <img src="{{asset('storage/'.$informe->imagen_amp)}}" width="680px" height="400px" alt="">
    </div>
    <div>
        <div style="background:; float:left;">
            <label class="tamanio">&nbsp;&nbsp;OBRA: Ampliacion</label><br>
            <label class="tamanio">&nbsp;&nbsp;CALLE: {{$informe->solicitud->calle_sol}} </label><br>
            <label class="tamanio">&nbsp;&nbsp;FECHA: {{ucfirst($Mes_)}}</label>
        </div>
        <div style="background:; float:right; ">
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
            <td class="centrar">PROVEEDOR</td>
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
            <td class="centrar" width="15px">{{$n++}}</td>
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
    <div class="centrar total" >{{$precio_total}}</div>

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
            <td class="centrar">PROVEEDOR</td>
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
            <td class="centrar" width="15px">{{$n++}}</td>
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
    @php
    $costo_total = $costo_total + $precio_total;
    @endphp
    <div class="centrar total" >{{$precio_total}}</div>
</div>
<br>
<br>
<table align="right">
    <tr>
        <td> <b>COSTO TOTAL DEL PROYECTO Bs.</b> </td>
        <td class="centrar" width="125px">{{$costo_total}}</td>
    </tr>
</table>
    <div><br><br>
        @foreach ($inspector as $i )
        <p align="center">{{$i->nombre_inspector}} <br> INSPECTOR</p>
        @endforeach
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
                // var obj = document.createElement('iframe');
                // obj.style.width = '100%';
                // obj.title = "Ampliación"
                // obj.style.height = window.screen.height + 'px';
                // obj.style.margin = '-10px'
                // obj.style.position = 'absolute'
                // obj.type = 'application/pdf';
                // obj.data = 'data:application/pdf;base64,' + pdf;
                // element.style.display = 'none';
                // document.body.appendChild(obj);

                var obj = document.createElement('object');
                obj.style.width = '100%';
                obj.style.height = window.screen.height + 'px';
                obj.style.margin = '-10px'
                obj.style.position = 'absolute'
                obj.type = 'application/pdf';
                obj.data = 'data:application/pdf;base64,' + pdf;
                // document.getElementById('title').innerText = "Ampliacion";
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
