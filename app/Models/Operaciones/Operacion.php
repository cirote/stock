<?php

namespace App\Models\Operaciones;

use App\Models\Broker;
use Error;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tightenco\Parental\HasChildren;

class Operacion extends Model
{
    use HasChildren;

    protected $table = 'operaciones';

    static public function migrar()
    {
        static::migrarPPI();
    }

    static public function migrarPPI()
    {
        static::registros(Broker::bySigla('PPI'), 'Movimientos 01.xlsx');
    }

    static public function registros(Broker $broker, $file)
    {
//        foreach($activo->tickers as $ticker)
//        {
            $url = storage_path("app/historico/BCBA/{$broker->sigla}/{$file}");

            if (! file_exists($url))
            {
                throw new error("El archivo [$url] no existe");
            }

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($url);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($url);

        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        var_dump($sheetData);

        dd($url);
//        }

        return [];
    }
}
