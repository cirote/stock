<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cirote\Movimientos\Actions\ImputarMovimientosOriginalesEnPosicionesAction as Imputar;

class imputarMovimientos extends Command
{
    protected $signature = 'populate:imputar';

    protected $description = 'Imputar las operaciones originales en posiciones';

    public function handle()
    {
    	$imputar = new Imputar();

        $imputar->execute();
    }
}
