<?php

use App\Models\Broker;
use App\Models\Operaciones\Migradores\Ppi;

class PpiOperacionesTableSeeder extends OperacionesTableSeeder
{
    public function run()
    {
        $this->broker = Broker::bySigla('PPI');

        $this->migrarArchivo('Movimientos 01.xlsx');
        $this->migrarArchivo('Movimientos 2019.xlsx');
    }

    public function migrarArchivo($file)
    {
        $libro = $this->leerLibro($file);

        $planillas = $libro->getSheetNames();

        foreach ($planillas as $planilla)
        {
            $datos = $libro->getSheetByName($planilla)->toArray(null, true, true, true);

            foreach ($datos as $dato)
            {
                Ppi::Migrate($dato, $this->broker);
            }
        }
    }
}
