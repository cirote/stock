<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\GrabarOperaciones;
use App\Models\Operaciones\Migradores\Bell;

class operacionesBell extends GrabarOperaciones
{
    protected $signature = 'populate:bell';

    protected $description = 'Carga lista de operaciones de BELL';

    protected $broker = 'BELL';

    protected $archivos = ['Hasta 2019.xlsx', 'Pesos 2020.xlsx', 'Dolar 2020.xlsx'];

    protected $migrador = Bell::class;
}
