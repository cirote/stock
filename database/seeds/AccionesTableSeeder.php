<?php

use Cirote\Activos\Models\Accion;
use Illuminate\Database\Seeder;

class AccionesTableSeeder extends Seeder
{
    public function run()
    {
        Accion::create([
            'denominacion' => 'Carboclor S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('CARC');

        Accion::create([
            'denominacion' => 'Banco Santander S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('SAN');

        Accion::create([
            'denominacion' => 'ITAU Unibanco S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('ITUB');

        Accion::create([
            'denominacion' => 'Petrobras S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('APBR')
            ->agregarTicker('PBR');

        Accion::create([
            'denominacion' => 'Ternium Argentina S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('TXAR')
            ->agregarTicker('ERAR');

        Accion::create([
            'denominacion' => 'Grupo Financiero Galicia S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('GGAL')
            ->agregarTicker('GFG');

        Accion::create([
            'denominacion' => 'Banco Supervielle S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('SUPV');

        Accion::create([
            'denominacion' => 'Tenaris S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('TS');

        Accion::create([
            'denominacion' => 'Phoenix Global Resources (ex Andes Energia)',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('PGR')
            ->agregarTicker('AEN');

        Accion::create([
            'denominacion' => 'Yacimientos Petroliferos Fiscales S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('YPF')
            ->agregarTicker('YPFD');
    }
}
