<?php

use App\Models\Activos\Historico;
use Illuminate\Database\Seeder;

class HistoricosTableSeeder extends Seeder
{
    public function run()
    {
        Historico::migrar();
    }
}
