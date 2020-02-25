<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\GrabarOperaciones;
use App\Models\Operaciones\Migradores\Iol;

class operacionesIOL extends GrabarOperaciones
{
    protected $signature = 'populate:iol';

    protected $description = 'Carga lista de operaciones de IOL';

    protected $broker = 'IOL';

    protected $archivos = ['MovimientosHistoricos.xlsx', 'Movimientos 2020.xlsx'];

    protected $migrador = Iol::class;
}
