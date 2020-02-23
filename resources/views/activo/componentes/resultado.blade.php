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
                <th>Resultado</th>
            </tr>
            @foreach($activos as $activo)
                @if(! $activo instanceof \App\Models\Activos\Moneda)
                <tr role="row" class="even">
                    <td><a href="{{ route('activo.mayor', ['activo' => $activo]) }}">{{ $activo->ticker }}</a></td>
                    <td>{{ $activo->denominacion }}</td>
                    <td align="right">{{ number_format(-$activo->costo, 0, ',', '.') }}</td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="box-footer">
    </div>

</div>
