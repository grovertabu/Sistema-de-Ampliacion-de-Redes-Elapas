@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>ELAPAS</h1>
@stop

{{-- @section('content')
    <p>Bienvenido.</p>
@stop --}}
@section('content')

    <h4>Bienvenido. <strong>{{auth()->user()->name}}</strong></h4>
    <img src="{{asset('css/ELAPAS.png')}}" alt="">
@stop
@section('footer')
<strong>{{date("Y")}} || ELAPAS - SISTEMA DE AMPLIACION DE REDES DE AGUA </strong>
@stop
@section('js')
    <script>
    </script>
@stop
