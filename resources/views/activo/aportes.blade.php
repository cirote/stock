@extends('adminlte::page')

@section('title', 'Brokers')

@section('content_header')
    <h1>Aportes</h1>
@stop

@section('content')
    <div class="col-md-8">
    @include('activo.componentes.aportes')
    </div>
@stop
