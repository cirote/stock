<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use League\Csv\Reader;

class Historico extends Model
{
    protected $dates = ['created_at', 'updated_at', 'fecha'];

    protected $fillable = ['fecha', 'activo_id', 'mercado_id', 'moneda_id', 'apertura', 'cierre', 'maximo',
        'minimo', 'volumen','interes_abierto'];

    static public function migrar()
    {
        foreach(Accion::all() as $activo)
        {
            static::migrarActivo($activo->ticker);
        }
    }

    static public function migrarActivo($ticker)
    {
        $activo = Activo::byTicker($ticker);
        $moneda = Accion::byTicker('$');

        foreach (static::registros($ticker) as $registro)
        {
            $historico = array_merge(
                $registro,
                [
                    'fecha'     => Carbon::create($registro['fecha']),
                    'interes_abierto' => $registro['openint'],
                    'mercado_id' => 1,
                    'activo_id' => $activo->id,
                    'moneda_id' => $moneda->id
                ]);

            unset($historico['openint']);

            static::create($historico);
        }
    }

    static public function registros($ticker)
    {
        $url = storage_path("stock/historico/$ticker.csv");

        if (! file_exists($url))
            return [];

        $csv = Reader::createFromPath($url, 'r');
        $csv->setHeaderOffset(0);

        return $csv->getRecords();
    }

}
