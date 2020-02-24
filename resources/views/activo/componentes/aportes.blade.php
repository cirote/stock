<div class="box box-info">

    <div class="box-header with-border">
        <h3 class="box-title">{{ $broker->nombre }} - Aportes y retiros</h3>
    </div>

    <div class="box-body no-padding">
        <table class="table table-condensed">
            <tbody>
            <tr>
                <th>Fecha</th>
                <th>Descripcion</th>
                <th>Monto</th>
                <th>Dolares</th>
            </tr>
            @php($stock = 0)
            @php($dolares = 0)
            @php($movimientos = $broker->operaciones()->paginate(8))
            @foreach($movimientos as $movimiento)
                <tr role="row" class="even">
                    <td>{{ date('d-m-Y', strtotime($movimiento->fecha)) }}</td>
                    <td>{{ Str::title(str_replace('_', ' ', Str::snake($movimiento->descripcion))) }}</td>
                    <td align="right">{{ number_format($movimiento->pesos, 2, ',', '.') }}</td>
                    <td align="right">{{ number_format($movimiento->dolares, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr role="row" class="even">
                <td></td>
                <td></td>
                <td></td>
                <td align="right">{{ number_format($broker->aportesNetos, 2, ',', '.') }}</td>
            </tr>
            </tbody>
        </table>
        {{ $movimientos->links() }}
    </div>

    <div class="box-footer">
    </div>

</div>
