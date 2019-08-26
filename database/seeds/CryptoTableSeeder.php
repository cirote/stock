<?php

use App\Models\Activos\Crypto;

use Illuminate\Database\Seeder;

class CryptoTableSeeder extends Seeder
{
    public function run()
    {
        Crypto::create(['denominacion' => 'Bitcoin'])
            ->agregarTicker('BTC');

        Crypto::create(['denominacion' => 'Ethereum'])
            ->agregarTicker('ETH');

        Crypto::create(['denominacion' => 'Tether'])
            ->agregarTicker('USDT');
    }
}
