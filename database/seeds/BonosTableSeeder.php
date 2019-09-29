<?php

use App\Models\Activos\Bono;
use Illuminate\Database\Seeder;

class BonosTableSeeder extends Seeder
{
    public function run()
    {
        Bono::create([
            'denominacion' => 'Bono de la Nación Argentina en dólares 8,75% vto. 2024',
            'clase'  => 'Bono'
        ])
            ->agregarTicker('AY24')
            ->agregarTicker('AY24D')
            ->agregarTicker('AY24C');

        Bono::create([
            'denominacion' => 'Bonos Internacionales de la República Argentina en dólares estadounidenses 7,125% 2117',
            'clase'  => 'Bono'
        ])
            ->agregarTicker('AC17')
            ->agregarTicker('AC17D')
            ->agregarTicker('AC17C');
    }
}
