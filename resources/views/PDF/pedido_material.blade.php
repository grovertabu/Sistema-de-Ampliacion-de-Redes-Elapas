@php
    setlocale(LC_TIME, "spanish");
    $fecha=strtotime(date("d-m-Y"));
    $anio=date("Y",$fecha);
    $mes=date("m", $fecha);
    $dia=date("d", $fecha);
    setlocale(LC_TIME, "spanish");
	$jefe_red="Rene Iglesias";		
    $Mes_ = strftime("%B", strtotime($mes));    
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido de material</title>

<style>
.letra{
    font-size: 26px;
}
.centrar{
    text-align: center;
}
.derecha{
    text-align: right;
}
.izquierda{
    width: 120px;
    text-align: left;
}
.contenido{
    height: 200px;
}
.sinBorde{ border-bottom:1px solid #fff}
u {    
    border-bottom: 1px dotted #000;
    text-decoration: none;
}
.img{
    width: 150px; height: 100px;
}
</style>
</head>
<body>
@php
    $pedido=10000+$informe->id;
@endphp
    <table width="100%">
        <tr>
            <td class="izquierda"><img class="img" src="{{asset('css/pedido.png')}}" alt=""></td>
            <td width="400px" class="letra centrar"><strong>Pedido de Materiales a Almacenes</strong></td>
            <td class="letra derecha">{{"0".$pedido}}</td>
        </tr>
    </table>
    <br>
    <div class="container">
        <table border="1" style="float:left; border-collapse:collapse; ">
        
        <tr align="center">
            <th>DIA</th>
            <th>MES</th>
            <th>AÑO</th>
        </tr>
        <tr align="center">
            <td>{{$dia}}</td>
            <td>{{$mes}}</td>
            <td>{{$anio}}</td>
        </tr>
        </table>

        <table style="float:left">
            <tr><td><strong>Programa:</strong></td><td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td></tr>
            <tr><td><strong>Actividad:</strong></td><td> <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;04
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td></tr>
        </table><br><br><br>
        <span><strong>Para Uso: </strong> <u>AMPLIACION DE TUBERIA MATRIZ DE 2" PVC BARRIO {{strtoupper($informe->solicitud->zona_sol)}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> </span>
        <span><strong>ITEM: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </u></strong></span>
        <table border="1" style=" margin-top:20px;border-collapse:collapse; width:100%;">
            <tr>
                <th align="center" style="width:100px;">Cantidad <br> Solicitada</th>
                <th align="center" style="width:100px;">Unidad de <br> medida</th>
                <th align="center">DESCRIPCION</th>
                <th align="center" style="width:100px;">Codigo</th>
            </tr>
            @foreach ($materiales as $material )
            <tr>
                
                <td  align="center">{{$material->cantidad}}</td>
                <td  align="center">{{$material->u_medida}}</td>
                <td  align="center">{{$material->nombre_material}}</td>
                <td  align="center"></td>    
                
            </tr>
            @endforeach
            <tr >
                <td style="height:15%; border-top:1px solid #fff"></td>
                <td style="height:15%; border-top:1px solid #fff"></td>
                <td style="height:15%; border-top:1px solid #fff"></td>
                <td style="height:15%; border-top:1px solid #fff"></td>
                
            </tr>
        </table>
        <table  border="1" style="border-collapse:collapse; width:100%;">
        <tr style="height:90px; margin:0px;">
            <td width="200px">Pedido Por: <br><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$inspector->name}} <br>&nbsp;&nbsp;&nbsp;<img width="120" height="60" src="{{asset('images/'.$inspector->name.'.png')}}"></strong></td>
                
                <td>Autorizado Por:<br><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$jefe_r->name}} <br>&nbsp;&nbsp;&nbsp;
                    @if($inspector->estado=='firmado')
                    <img width="120" height="60" src="{{asset('images/'.$jefe_red.'.png')}}">
                    @endif
                </td>
                <td>Vo.Bo. <br><br><br><br></td>
                <td>Vo.Bo. <br><br><br><br></td>
            </tr>
            <tr align="center">
                <td style="">Nombre Firma</td>
                <td style="">Jefe de Sección</td>
                <td style="">Gerencia Área</td>
                <td style="">Gerencia Administrativa</td>
            </tr>
        </table>
    </div>



</body>
</html>