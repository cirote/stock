<?php

use App\Models\Activos\Accion;
use Illuminate\Database\Seeder;

class AccionesTableSeeder extends Seeder
{
    public function run()
    {
        Accion::create([
            'denominacion' => 'Ternium Argentina S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('TXAR')
            ->agregarTicker('ERAR');

        Accion::create([
            'denominacion' => 'Petrobras S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('APBR')
            ->agregarTicker('PBR');


        Accion::create([
            'denominacion' => 'Banco Santander S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('SAN');
    }
}
