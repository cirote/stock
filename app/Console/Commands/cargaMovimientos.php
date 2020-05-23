<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cirote\Movimientos\Actions\MigratosDatosOriginales\CopiarDatosDeBellAlFormatoComunAction as Bell;
use Cirote\Movimientos\Actions\MigratosDatosOriginales\CopiarDatosDeIolAlFormatoComunAction as Iol;
use Cirote\Movimientos\Actions\MigratosDatosOriginales\CopiarDatosDePpiAlFormatoComunAction as Ppi;

class cargaMovimientos extends Command
{
    protected $signature = 'populate:movimientos';

    protected $description = 'Migración de las operaciones originales';

    public function handle()
    {
    	$bell = new Bell();

        $bell->execute();

    	$iol = new Iol();

        $iol->execute();

    	$ppi = new Ppi();

        $ppi->execute();
    }
}
