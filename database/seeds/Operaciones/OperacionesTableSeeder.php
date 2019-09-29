<?php

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class OperacionesTableSeeder extends Seeder
{
    protected $broker;

    public function leerLibro($file)
    {
        $url = storage_path("app/historico/BCBA/{$this->broker->sigla}/{$file}");

        if (! file_exists($url))
            throw new error("El archivo [$url] no existe");

        $reader = IOFactory::createReaderForFile($url);
        $reader->setReadDataOnly(true);

        return $reader->load($url);
    }

    function tofloat($num)
    {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
            ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

        if (!$sep) {
            return abs(floatval(preg_replace("/[^0-9]/", "", $num)));
        }

        $float = floatval(
            preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
        );

        return abs($float);
    }
}
