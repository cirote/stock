@extends('adminlte::page')

@section('title', 'Stocks')

@section('content_header')
    <h1>Pagina principal</h1>
@stop

@section('content')
    @include('activo.lista')
@stop