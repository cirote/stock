<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title">Operaciones de compra / venta</h3>
    </div>

    <div class="box-body no-padding">
        <table class="table table-condensed">
            <tbody>
            <tr>
                <th>Fecha</th>
                <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Importe</th>
                <th>Dolares</th>
            </tr>
            @php($stock = 0)
            @php($dolares = 0)
            @php($movimientos = $activo->operaciones()->paginate(8))
            @foreach($movimientos as $movimiento)
                <tr role="row" class="even">
                    <td>{{ date('d-m-Y', strtotime($movimiento->fecha)) }}</td>
                    <td>{{ Str::title(str_replace('_', ' ', Str::snake($movimiento->descripcion))) }}</td>
                    @if($movimiento->cantidad)
                    <td align="right">{{ number_format($movimiento->cantidad, 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($movimiento->precio, 2, ',', '.') }}</td>
                    @else
                    <td></td>
                    <td></td>
                    @endif
                    <td align="right">{{ number_format($movimiento->pesos, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($movimiento->dolares, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr role="row" class="even">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">{{ number_format($activo->costo, 2, ',', '.') }}</td>
            </tr>
            </tbody>
        </table>
        {{ $movimientos->links() }}
    </div>

    <div class="box-footer">
    </div>

</div>
