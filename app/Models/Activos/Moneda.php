<?php

namespace App\Models\Activos;

use Illuminate\Support\Facades\DB;
use Tightenco\Parental\HasParent;

class Moneda extends Activo
{
    use HasParent;

    static public function makePesosPorDolar()
    {
        $tenaris = Activo::byTicker('TS');

        $peso = Activo::byTicker('$');
        $dolar = Activo::byTicker('USD');

        $enPesos = DB::table('historicos')
            ->select('fecha as fechaPesos', 'cierre as pesos')
            ->where('activo_id', $tenaris->id)
            ->where('moneda_id', $peso->id);

        return DB::table('historicos')
            ->select('fecha', 'cierre as dolares', 'pesos', DB::raw('(2 * pesos / cierre) as cotizacion'))
            ->where('activo_id', $tenaris->id)
            ->where('moneda_id', $dolar->id)
            ->joinSub($enPesos, 'enPesos', function ($join) {
                $join->on('historicos.fecha', 'enPesos.fechaPesos');
            });
    }
}
