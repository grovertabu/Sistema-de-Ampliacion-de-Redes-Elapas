<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Escaneada
    </title>
</head>

<body>
    <x-header/>
    <div class="container">
        <img src="{{ asset('solicitudes/' . $solicitud->sol_escaneada) }}" width="100%" alt="">
    </div>
</body>

</html>
