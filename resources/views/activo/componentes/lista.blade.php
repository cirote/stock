<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title">Acciones</h3>
    </div>

    <div class="box-body no-padding">
        <table class="table table-condensed">
            <tbody>
            <tr>
                <th>Ticker</th>
                <th>Activo</th>
                <th>Cantidad</th>
                <th>Inversion</th>
                <th>Dividendos</th>
                <th>Lanzamientos</th>
                <th>I. Neta</th>
                <th>Precio</th>
                <th>Valor</th>
                <th>Relacion</th>
            </tr>

            @php($costo = 0)
            @php($valor = 0)

            @foreach($activos as $activo)
                @if(! $activo instanceof \App\Models\Activos\Moneda)
                <tr role="row" class="even">
                    <td><a href="{{ route('activo.mayor', ['activo' => $activo]) }}">{{ $activo->ticker->ticker }}</a></td>
                    <td>
                        {{ $activo->denominacion }}
                        @if($activo->calls->count())
                            <a class="btn btn-sm btn-info" href="{{ route('opciones.activo', ['activo' => $activo]) }}">Calls</a>
                            <span class="pull-right-container">
                                <small class="label pull-right bg-yellow">Calls</small>
                            </span>
                        @endif
                    </td>
                    <td align="right">{{ number_format($activo->cantidad, 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($activo->costoDolares, 0, ',', '.') }}</td>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td align="right">{{ number_format($activo->precioActualPesos, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($activo->valorActualDolares, 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($activo->relacionCostoValorDolares, 0, ',', '.') }}</td>
                </tr>

                @php($costo += $activo->costoDolares)
                @php($valor += $activo->valorActualDolares)

                @endif
            @endforeach

            <tr role="row" class="odd">
                <td></td>
                <td></td>
                <td></td>
                <td align="right">{{ number_format($costo, 0, ',', '.') }}</td>
                <td align="right">{{ number_format($valor, 0, ',', '.') }}</td>
                <td align="right">{{ number_format($valor - $costo, 0, ',', '.') }}</td>
            </tr>

            </tbody>
        </table>
    </div>

    <div class="box-footer">
    </div>

</div>
