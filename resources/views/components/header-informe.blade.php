<style>
    .izquierdo{
        float: left;
        text-align: center !important;
        display: flex;
    }
    .derecha{
        float: right;
        text-align: right !important;
    }
</style>

<div class="header">
    <div class="izquierdo">
        <img src="{{ asset('images/pedido.png') }}" style="width:100px; height:50px" alt="">
        <b>Sistema informático de Ampliación de agua</b>
    </div>

    <div class="derecha">
        <b>Fecha de Impresión: </b><br>{{ date('Y-m-d H:i:s') }}
    </div>
</div>
