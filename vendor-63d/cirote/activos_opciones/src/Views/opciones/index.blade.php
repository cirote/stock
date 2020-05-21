@extends('opciones::layouts.master')

@section('main_content')
<div class="row">
	<div class="col-md-10">
		<div class="box box-info">

		    <div class="box-header with-border">
		        <h3 class="box-title">Total de opciones</h3>
		    </div>

		    <div class="box-body">
		    	@include('opciones::opciones.opciones_lista')
		    </div>

			<div class="box-footer clearfix">
				{{ $activos->links('layouts::pagination.default') }}
			</div>

		</div>
	</div>
</div>
@endsection
