@extends('adminlte::page')

@section('title', 'Stocks')

@section('content_header')
    <h1>({{ $activo->ticker }}) {{ $activo->denominacion }}</h1>
@stop

@section('content')
    <div class="col-md-8">
    @include('activo.componentes.mayor')
    </div>
@stop
