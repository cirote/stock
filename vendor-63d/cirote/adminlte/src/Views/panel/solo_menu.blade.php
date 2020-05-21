@extends('layouts::master')

@section('module_skin', 'skin-blue')

@section('module_layout', 'sidebar-mini')

@section('styles')
    @parent
@endsection

@section('main_header')
    @includeIf('layouts::mainheader')
@endsection

@section('menu')
    @includeIf('layouts::menu')
@endsection

{{--
@section('content_header')
    <section class="content-header">
        <h1>@yield('content_header_title', 'RELEX')<small>@yield('content_header_description')</small><div class="pull-right">@yield('content_header_extras')</div></h1>
        @include('layouts.partials.alerts')
    </section>
@endsection
--}}

@section('control_sidebar')
    {{--@include('adminlte::layouts.partials.controlsidebar')--}}
@endsection

@section('footer')
    @includeIf('layouts.partials.footer')
@endsection

@section('scripts')
    @parent
@endsection