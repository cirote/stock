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
}
