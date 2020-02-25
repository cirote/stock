<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\GrabarOperaciones;
use App\Models\Operaciones\Migradores\Af;

class operacionesAfluenta extends GrabarOperaciones
{
    protected $signature = 'populate:afluenta';

    protected $description = 'Carga lista de operaciones de Afluenta';

    protected $broker = 'AF';

    protected $archivos = ['OH Afluenta.xlsx'];

    protected $migrador = Af::class;
}
