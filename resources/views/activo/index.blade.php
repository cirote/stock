@extends('adminlte::page')

@section('title', 'Stocks')

@section('content_header')
    <h1>Pagina principal</h1>
@stop

@section('content')
    <div class="col-md-6">
    @include('activo.componentes.lista')
    </div>
@stop
