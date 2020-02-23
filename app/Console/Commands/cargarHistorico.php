<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activos\Historico;

class cargarHistorico extends Command
{
    protected $signature = 'populate:historico';

    protected $description = 'Carga la informacion historica de los movimientos que esta en la carpeta app';

    public function handle()
    {
    	Historico::truncate();
    	
        Historico::migrar();
    }
}
