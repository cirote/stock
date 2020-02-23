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
                <th>Stock</th>
                <th>Precio</th>
                <th>Importe</th>
                <th>Dolares</th>
            </tr>
            @php($stock = 0)
            @php($dolares = 0)
            @php($movimientos = $activo->operaciones()->paginate(100))
            @foreach($movimientos as $movimiento)

                @php($stock += $movimiento->cantidad * ($movimiento instanceof \App\Models\Operaciones\Compra))
                @php($stock -= $movimiento->cantidad * ($movimiento instanceof \App\Models\Operaciones\Venta))
                @php($stock -= $movimiento->cantidad * ($movimiento instanceof \App\Models\Operaciones\EjercicioVendedor))

                @php($dolares += $movimiento->dolares * ($movimiento instanceof \App\Models\Operaciones\Compra))
                @php($dolares -= $movimiento->dolares * ($movimiento instanceof \App\Models\Operaciones\Venta))
                @php($dolares -= $movimiento->dolares * ($movimiento instanceof \App\Models\Operaciones\EjercicioVendedor))

                <tr role="row" class="even">
                    <td>{{ date('d-m-Y', strtotime($movimiento->fecha)) }}</td>
                    <td>{{ $movimiento->descripcion }}</td>
                    <td align="right">{{ number_format($movimiento->cantidad, 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($stock, 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($movimiento->precio, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($movimiento->pesos, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($movimiento->dolares, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $movimientos->links() }}
    </div>

    <div class="box-footer">
        <tr role="row" class="even">
            <table class="table table-condensed">
                <tbody>
                    <td>*</td>
                    <td>*</td>
                    <td align="right">*</td>
                    <td align="right">*</td>
                    <td align="right">*</td>
                    <td align="right">*</td>
                    <td align="right">{{ number_format($dolares, 2, ',', '.') }}</td>
                </tbody>
            </table>
        </tr>
    </div>

</div>
