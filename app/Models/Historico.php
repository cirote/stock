<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use League\Csv\Reader;

class Historico extends Model
{
    protected $dates = ['created_at', 'updated_at', 'fecha'];

    static public function migrar()
    {
        $ticker = 'APBR';

        $url = storage_path("stock/historico/$ticker.csv");

        $csv = Reader::createFromPath($url, 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader();
        $records = $csv->getRecords();

        $activo = Activo::byTicker($ticker);
        $moneda = Accion::byTicker('$');

        foreach ($records as $record) {

            $historico = array_merge(
                $record,
                [
                    'fecha'     => Carbon::create($record['fecha']),
                    'interes_abierto' => $record['openint'],
                    'activo_id' => $activo->id,
                    'moneda_id' => $moneda->id
                ]);

            unset($historico['openint']);

            static::create($historico);
        }

    }
}
