<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cirote\Movimientos\Actions\MigratosDatosOriginales\CopiarDatosDeBellAlFormatoComunAction as Bell;
use Cirote\Movimientos\Actions\MigratosDatosOriginales\CopiarDatosDeIolAlFormatoComunAction as Iol;
use Cirote\Movimientos\Actions\MigratosDatosOriginales\CopiarDatosDePpiAlFormatoComunAction as Ppi;

class operacionesIOL extends Command
{
    protected $signature = 'populate:prueba';

    protected $description = 'Carga lista de operaciones de IOL';

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
