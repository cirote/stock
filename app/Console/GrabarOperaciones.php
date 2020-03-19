<?php

namespace App\Console;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Broker;

class GrabarOperaciones extends Command
{
    private $_broker;

    protected function leerLibro($file)
    {
        $url = storage_path("app/historico/BCBA/{$this->getBroker()->sigla}/{$file}");

        if (! file_exists($url))
            throw new \error("El archivo [$url] no existe");

        $reader = IOFactory::createReaderForFile($url);
        $reader->setReadDataOnly(true);

        return $reader->load($url);
    }

    public function handle()
    {
        $this->cargarDatos();
    }

    protected function getBroker(): Broker
    {
        if (! $this->_broker) 
        {
            $this->_broker = Broker::bySigla($this->broker);
        }

        return $this->_broker;
    }

    protected function cargarDatos()
    {
        foreach ($this->archivos as $archivo) 
        {
            $this->migrarArchivo($archivo);
        }
    }

    protected function migrarArchivo($file)
    {
        $libro = $this->leerLibro($file);

        $planillas = $libro->getSheetNames();

        foreach ($planillas as $planilla)
        {
            $datos = $libro->getSheetByName($planilla)->toArray(null, true, true, true);

            foreach ($datos as $dato)
            {
                $this->migrador::Migrate($dato, $planilla, $this->getBroker());
            }
        }
    }
}
