<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title">Brokers</h3>
    </div>

    <div class="box-body no-padding">
        <table class="table table-condensed">
            <tbody>
            <tr>
                <th>Sigla</th>
                <th>Nombre</th>
                <th>Aportes</th>
                <th>Otros</th>
            </tr>
            @php($total = 0)
            @foreach($brokers as $broker)
            @php($total += $broker->aportesNetos)
                <tr role="row" class="even">
                    <td><a href="{{ route('broker.aportes', ['broker' => $broker]) }}">{{ $broker->sigla }}</a></td>
                    <td>{{ $broker->nombre }}</td>
                    <td align="right">{{ number_format($broker->aportesNetos, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            @endforeach
            <tr role="row" class="even">
                <td></td>
                <td><b>Total de aportes</b></td>
                <td align="right"><b>{{ number_format($total, 0, ',', '.') }}</b></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="box-footer">
    </div>

</div>
