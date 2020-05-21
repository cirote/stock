@extends('opciones::layouts.master')

@section('main_content')
<div class="row">
	<div class="col-md-4">
		<div class="box">

			<div class="box-header with-border">
				<h3 class="box-title">Opciones de {{ $activo->denominacion }}</h3>
			</div>

			<div class="box-body">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th style="width: 10px">#</th>
							<th>Ticker</th>
							<th>Año</th>
							<th>Mes</th>
							<th>Strike</th>
							<th>Tipo</th>
						</tr>
						@foreach($opciones as $opcion)
						<tr>
							<td>{{ $opciones->firstItem() + $loop->index }}.</td>
							<td>{{ $opcion->ticker }}</td>
							<td>{{ $opcion->vencimiento->year }}</td>
							<td>{{ $opcion->vencimiento->month }}</td>
							<td>{{ number_format($opcion->strike, 2, '.', ',') }}</td>
							<td>{{ $opcion->tipo }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="box-footer clearfix">
				<a href="{{ route('inexistentes.index') }}" class="btn btn-info btn-sm">Regresar</a>
				<a href="{{ route('inexistentes.agregar', ['activo' => $activo]) }}" class="btn btn-success btn-sm">Agregar a la base</a>
				<a href="{{ route('inexistentes.borrar', ['activo' => $activo]) }}" class="btn btn-danger btn-sm">Borrar</a>
				{{ $opciones->links('layouts::pagination.default') }}
			</div>

		</div>
	</div>
</div>
@endsection