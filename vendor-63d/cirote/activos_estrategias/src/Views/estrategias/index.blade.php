@extends('opciones::layouts.master')

@section('main_content')
<div class="row">
	<div class="col-md-8">
		<div class="box">

			<div class="box-header with-border">
				<h3 class="box-title">Lanzamientos en descubierto con compra del subyacente</h3>
			</div>

			<div class="box-body">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th rowspan="2" style="width: 10px">#</th>
							<th colspan="4">A Comprar</th>
							<th colspan="5">A Vender</th>
							<th colspan="5">Operacion a realizar</th>
						</tr>
						<tr>
							<th>Ticker</th>
							<th>Activo</th>
							<th>Cantidad</th>
							<th>Precio</th>

							<th>Ticker</th>
							<th>Strike</th>
							<th>Dias</th>
							<th>Cantidad</th>
							<th>Precio</th>

							<th>Activos</th>
							<th>Lotes</th>
							<th>Monto</th>
							<th>Tasa</th>
							<th>TNA</th>
						</tr>
						@foreach($lanzamientos as $lanzamiento)
						<tr>
							<td>{{ $lanzamientos->firstItem() + $loop->index }}.</td>

							<td>{{ $lanzamiento->subyacente->ticker->ticker }}</td>
							<td>{{ $lanzamiento->subyacente->denominacion }}</td>
							<td>{{ $lanzamiento->subyacente->ask->cantidad }}</td>
							<td>{{ $lanzamiento->subyacente->ask->precio }}</td>
							
							<td>{{ $lanzamiento->call->ticker->ticker }}</td>
							<td>{{ $lanzamiento->call->strike }}</td>
							<td>{{ $lanzamiento->call->dias }}</td>
							<td>{{ $lanzamiento->call->bid->cantidad }}</td>
							<td>{{ $lanzamiento->call->bid->precio }}</td>

							<td></td>							
							<td></td>							
							<td></td>							
							<td>{{ number_format($lanzamiento->tasa * 100, 2, '.', ',') }}</td>							
							<td>{{ number_format($lanzamiento->TNA * 100, 2, '.', ',') }}</td>							
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="box-footer clearfix">
				{{ $lanzamientos->links('layouts::pagination.default') }}
			</div>

		</div>
	</div>
</div>
@endsection
