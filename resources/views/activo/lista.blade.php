<div class="col-md-6">

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
                </tr>
                @foreach($activos as $activo)
                    @if(! $activo instanceof \App\Models\Activos\Moneda)
                    <tr role="row" class="even">
                        <td>{{ $activo->ticker }}</td>
                        <td>{{ $activo->denominacion }}</td>
                        <td align="right">{{ number_format($activo->cantidad, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="box-footer">
        </div>

    </div>

</div>
