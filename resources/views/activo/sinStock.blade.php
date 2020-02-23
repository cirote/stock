@extends('adminlte::page')

@section('title', 'Stocks')

@section('content_header')
    <h1>Activos sin stocks</h1>
@stop

@section('content')
    <div class="col-md-6">
    @include('activo.componentes.resultado')
    </div>
@stop
