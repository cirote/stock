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
//            ->agregarMercado('BCBA - Inmediata', '$', 'APBR', 'TXAR', 'TS', 'SAN', 'AY24')
            ->agregarMercado('BCBA - 48 hs', '$', 'APBR', 'TXAR', 'TS', 'SAN', 'AY24', 'YPFD')
//            ->agregarMercado('Contado con liquidacion - Inmediata', 'USD', 'AY24C')
            ->agregarMercado('Contado con liquidacion - 48 hs', 'USD', 'AY24C')
//            ->agregarMercado('Dolar MEP - Inmediata', 'USD', 'AY24D')
            ->agregarMercado('Dolar MEP - 48 hs', 'USD', 'AY24D');

        Bolsa::create([
            'nombre' => 'New York Stock Exchange',
            'sigla'  => 'NYSE'
        ])
            ->agregarMercado('NYSE', 'USD', 'TS', 'PBR', 'SAN');

        Bolsa::create([
            'nombre' => 'OKEx',
            'sigla'  => 'OKEX'
        ])
            ->agregarMercado('OKEx-BTC', 'BTC')
            ->agregarMercado('OKEx-ETH', 'ETH');
    }
}
