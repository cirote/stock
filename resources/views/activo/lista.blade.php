<div class="col-md-6">

    <div class="box box-info">

        <div class="box-header with-border">
            <h3 class="box-title">Acciones</h3>
        </div>

        <div class="box-body no-padding">
            <table class="table table-condensed">
                <tbody>
                <tr>
                    <th>Activo</th>
                    <th>Task</th>
                    <th>Progress</th>
                </tr>
                @foreach($activos as $activo)
                    <tr role="row" class="even">
                        <td>{{ $activo->denominacion }}</td>
                        <td>Mozilla 1.0</td>
                        <td>Win 95+ / OSX.1+</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="box-footer">
        </div>

    </div>

</div>
