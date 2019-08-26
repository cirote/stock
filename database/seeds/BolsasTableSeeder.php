<?php

use App\Models\Activos\Bolsa;
use Illuminate\Database\Seeder;

class BolsasTableSeeder extends Seeder
{
    public function run()
    {
        Bolsa::create([
            'nombre' => 'Bolsa de Comercio de Buenos Aires',
            'sigla'  => 'BCBA'
        ])
            ->agregarMercado('BCBA 48 hs', '$', 'APBR', 'TXAR', 'SAN', 'AY24')
            ->agregarMercado('Contado con liquidacion', 'USD', 'AY24C')
            ->agregarMercado('Dolar MEP', 'USD', 'AY24D');

        Bolsa::create([
            'nombre' => 'New York Stock Exchange',
            'sigla'  => 'NYSE'
        ])
            ->agregarMercado('NYSE', 'USD', 'PBR', 'SAN');

        Bolsa::create([
            'nombre' => 'OKEx',
            'sigla'  => 'OKEX'
        ])
            ->agregarMercado('OKEx-BTC', 'BTC')
            ->agregarMercado('OKEx-ETH', 'ETH');
    }
}
