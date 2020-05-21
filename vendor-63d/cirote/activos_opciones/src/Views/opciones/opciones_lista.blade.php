<table class="table table-bordered">

    <thead>
        <tr>  
            <th rowspan="2" style="width: 10px">#</th>
            <th rowspan="2" align="left" halign="center"><b>Ticker</b></th>
            <th rowspan="2" align="left" halign="center"><b>Subyacente</b></th>
            <th rowspan="2" align="left" halign="center"><b>Strike</b></th>
            <th rowspan="2" salign="right" halign="center"><b>Teorico</b></th>
            <th rowspan="2" align="right" halign="center"><b>VI</b></th>
            <th rowspan="2" align="center" halign="center"><b>Estado</b></th>
            <th rowspan="2" align="center" halign="center"><b>Dias</b></th>
            <th colspan="5" align="center"><b>Compra</b></th>
            <th colspan="2" align="center"><b>PE</b></th>
            <th rowspan="2" align="right" halign="center"><b>Ultimo</b></th>
            <th colspan="5" align="center"><b>Venta</b></th>
        </tr> 
        <tr>  
            <th align="right" formatter="formatTasa" halign="center"><b>TNA</b></th>
            <th align="right" formatter="formatTasaDec" halign="center"><b>Tasa</b></th>
            <th align="right" halign="center"><b>Volatilidad</b></th>
            <th align="right" halign="center"><b>Q</b></th>
            <th align="right" halign="center"><b>$</b></th>

            <th field="PECompra" align="right" formatter="formatPrecioEC" halign="center"><b>C</b></th>
            <th field="PEVenta" align="right" formatter="formatPrecioEV" halign="center"><b>V</b></th>

            <th align="right" halign="center"><b>$</b></th>
            <th align="right" halign="center"><b>Q</b></th>
            <th align="right" halign="center"><b>Volatilidad</b></th>
            <th align="right" formatter="formatTasaDec" halign="center"><b>Tasa</b></th>
            <th align="right" formatter="formatTasa" halign="center"><b>TNA</b></th>
        </tr>  
    </thead>  

    <tbody>
        @php($costo = 0)
        @php($valor = 0)

        @foreach($activos as $activo)
            @if(! $activo instanceof \App\Models\Activos\Moneda)
            <tr role="row" class="even">
                <td>{{ $activos->firstItem() + $loop->index }}.</td>
                <td><a href="{{ route('activo.mayor', ['activo' => $activo]) }}">{{ $activo->ticker->ticker }}</a></td>
                <td align="right">{{ number_format($activo->subyacente->precioActualPesos, 2, ',', '.') }}</td>
                <td align="right">{{ number_format($activo->strike, 2, ',', '.') }}</td>
                <td align="right">{{ number_format($activo->precioTeorico, 2, ',', '.') }}</td>
                @if($activo->valorImplicito)
                    <td align="right">{{ number_format($activo->valorImplicito, 2, ',', '.') }}</td>
                @else
                    <td></td>
                @endif
                <td align="right">{{ $activo->estado }}</td>
                <td align="right">{{ $activo->dias }}</td>

                @if($activo->bid->cantidad)
                    <td align="right">{{ number_format($activo->bid->tasaNeta * 100, 0, ',', '.') }}%</td>
                    <td align="right">{{ number_format($activo->bid->tasa * 100, 2, ',', '.') }}%</td>
                    <td align="right">{{ number_format($activo->bid->volatilidadImplicita, 2, ',', '.') }}%</td>
                    <td align="right">{{ number_format($activo->bid->cantidad, 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($activo->bid->precio, 2, ',', '.') }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif

                @if($activo->PrecioActualPesos)
                    <td align="right">{{ number_format($activo->bid->equivalenteCompra, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($activo->bid->equivalenteVenta, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($activo->PrecioActualPesos, 2, ',', '.') }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                @endif

                @if($activo->ask->cantidad)
                    <td align="right">{{ number_format($activo->ask->precio, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($activo->ask->cantidad, 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($activo->ask->volatilidadImplicita, 2, ',', '.') }}%</td>
                    <td align="right">{{ number_format($activo->ask->tasa * 100, 2, ',', '.') }}%</td>
                    <td align="right">{{ number_format($activo->ask->tasaNeta * 100, 0, ',', '.') }}%</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
            </tr>

            @php($costo += $activo->costoDolares)
            @php($valor += $activo->valorActualDolares)

            @endif
        @endforeach

    </tbody>
</table>
