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
            ->agregarTicker('CARC.BA', 'Acción', 1, 0, 1, 0)
            ->agregarTicker('CARC', 'Acción', 1, 1);

        Accion::create([
            'denominacion' => 'Banco Santander S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('SAN', 'ADR', 1, 1, 0, 1);

        Accion::create([
            'denominacion' => 'ITAU Unibanco S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('ITUB', 'ADR', 1, 1, 0, 1);

        Accion::create([
            'denominacion' => 'Petrobras S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('APBR')
            ->agregarTicker('PBR', 'ADR', 1, 1, 0, 1);

        Accion::create([
            'denominacion' => 'Ternium Argentina S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('TXAR', 'Acción', 1, 1)
            ->agregarTicker('TXAR.BA', 'Acción', 1, 0, 1, 0)
            ->agregarTicker('ERAR');

        Accion::create([
            'denominacion' => 'Grupo Financiero Galicia S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('GGAL', 'ADR', 10, 1, 0, 1)
            ->agregarTicker('GFG')
            ->agregarTicker('GFG.BA', 'Acción', 1, 0, 1, 0);

        Accion::create([
            'denominacion' => 'Banco Supervielle S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('SUPV', 'ADR', 5, 1, 0, 1);

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
            ->agregarTicker('PGR.BA', 'Acción', 1, 0, 1, 0)
            ->agregarTicker('AEN');

        Accion::create([
            'denominacion' => 'Yacimientos Petroliferos Fiscales S.A.',
            'clase'  => 'Acciones ordinarias'
        ])
            ->agregarTicker('YPF', 'ADR', 1, 0, 0, 1)
            ->agregarTicker('YPFD.BA', 'Acción', 1, 0, 1, 0)
            ->agregarTicker('YPFD', 'Acción', 1, 1);
    }
}
