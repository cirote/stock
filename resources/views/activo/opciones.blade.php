@extends('adminlte::page')

@section('title', 'Stocks')

@section('content_header')
    <h1>{{ $titulo }}</h1>
@stop

@section('content')
    <div class="col-md-9">
    	@include('activo.componentes.opciones_lista')
    </div>
@stop
