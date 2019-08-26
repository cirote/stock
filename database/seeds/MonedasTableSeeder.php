<?php

use App\Models\Activos\Moneda;
use Illuminate\Database\Seeder;

class MonedasTableSeeder extends Seeder
{
    public function run()
    {
        Moneda::create(['denominacion' => 'Dolar Americano'])
            ->agregarTicker('U$D')
            ->agregarTicker('USD');

        Moneda::create(['denominacion' => 'Peso Argentino'])
            ->agregarTicker('$')
            ->agregarTicker('$A');

        Moneda::create(['denominacion' => 'Peso Uruguayo'])
            ->agregarTicker('$U');

    }
}
