<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\GrabarOperaciones;
use App\Models\Operaciones\Migradores\Ppi;

class operacionesPPI extends GrabarOperaciones
{
    protected $signature = 'populate:ppi';

    protected $description = 'Carga lista de operaciones de PPI';

    protected $broker = 'PPI';

    protected $archivos = ['Movimientos 01.xlsx', 'Movimientos 2019.xlsx'];

    protected $migrador = Ppi::class;
}
