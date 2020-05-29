<?php

use Cirote\Activos\Models\Broker;
use Illuminate\Database\Seeder;

class BrokerTableSeeder extends Seeder
{
    public function run()
    {
        Broker::create([
            'nombre' => 'Invertir On Line',
            'sigla' => 'IOL'
        ]);

        Broker::create([
            'nombre' => 'Portfolio Personal Inversiones',
            'sigla' => 'PPI'
        ]);

        Broker::create([
            'nombre' => 'Bell Investments',
            'sigla' => 'BELL'
        ]);

        Broker::create([
            'nombre' => 'Afluenta',
            'sigla' => 'AF'
        ]);

        Broker::create([
            'nombre' => 'Okex',
            'sigla' => 'OKEX'
        ]);
    }
}
