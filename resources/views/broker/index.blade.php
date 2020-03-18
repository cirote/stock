@extends('adminlte::page')

@section('title', 'Stocks')

@section('content_header')
    <h1>Brokers</h1>
@stop

@section('content')
    <div class="col-md-8">
    @include('broker.componentes.lista')
    </div>
@stop
