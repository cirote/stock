<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use League\Csv\Reader;

class Historico extends Model
{
    protected $dates = ['created_at', 'updated_at', 'fecha'];

    protected $fillable = ['fecha', 'activo_id', 'mercado_id', 'moneda_id', 'apertura', 'cierre', 'maximo',
        'minimo', 'volumen','interes_abierto'];

    static public function migrar()
    {
        foreach(Mercado::all() as $mercado)
        {
            foreach ($mercado->activos as $activo)
            {
                static::migrarActivo($activo, $mercado);
            }
        }
    }

    static public function migrarActivo(Activo $activo, Mercado $mercado)
    {
        foreach (static::registros($activo, $mercado) as $registro)
        {
            $historico =
                [
                    'fecha'      => Carbon::create($registro['fecha']),
                    'apertura'   => static::cleanNumber($registro['apertura']),
                    'maximo'     => static::cleanNumber($registro['maximo']),
                    'minimo'     => static::cleanNumber($registro['minimo']),
                    'cierre'     => static::cleanNumber($registro['cierre']),
                    'volumen'    => static::cleanNumber($registro['volumen']),
                    'interes_abierto' => $registro['openint'],
                    'mercado_id' => $mercado->id,
                    'activo_id'  => $activo->id,
                    'moneda_id'  => $mercado->moneda->id
                ];

            unset($historico['openint']);

            static::create($historico);
        }
    }

    static public function registros(Activo $activo, Mercado $mercado)
    {
        foreach($activo->tickers as $ticker)
        {
            $url = storage_path("app/historico/{$mercado->bolsa->sigla}/{$mercado->nombre}/{$ticker->ticker}.csv");

            if (file_exists($url))
            {
                $csv = Reader::createFromPath($url, 'r');
                $csv->setHeaderOffset(0);

                return $csv->getRecords();
            }
        }

        return [];
    }

    static function cleanNumber($number)
    {
        if (is_numeric($number))
            return $number;

        $number = str_replace(',', '.', $number);

        if (Str::endsWith($number, 'M'))
        {
            $number = substr($number, 0, -1) * 1000000;
        }

        if (Str::endsWith($number, 'K'))
        {
            $number = substr($number, 0, -1) * 1000;
        }

        return $number;
    }


    public function toGraph()
    {
        return [
            $this->fecha->timestamp * 1000,
            $this->apertura,
            $this->maximo,
            $this->minimo,
            $this->cierre,
            $this->volumen
        ];
    }
}
