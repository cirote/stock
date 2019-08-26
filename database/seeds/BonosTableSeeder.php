<?php

use App\Models\Activos\Bono;
use Illuminate\Database\Seeder;

class BonosTableSeeder extends Seeder
{
    public function run()
    {
        Bono::create([
            'denominacion' => 'Bono de la Nación Argentina en dólares 8,75% vto. 2024',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('AY24')
            ->agregarTicker('AY24D')
            ->agregarTicker('AY24C');

    }
}
