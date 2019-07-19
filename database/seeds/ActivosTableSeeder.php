<?php

use App\Models\Activos\CriptoMonedas\Cripto;
use Illuminate\Database\Seeder;

class ActivosTableSeeder extends Seeder
{
    public function run()
    {
        Cripto::create([
                'nombre' => 'Bitcoin'
            ])
            ->tickers()->create([
                    'ticker' => 'BTC'
                ]);

        Cripto::create([
                'nombre' => 'Ethereum'
            ])
            ->tickers()->create([
                'ticker' => 'ETH'
            ]);

        Cripto::create([
                'nombre' => 'Tether'
            ])
            ->tickers()->create([
                'ticker' => 'USDT'
            ]);
    }
}
