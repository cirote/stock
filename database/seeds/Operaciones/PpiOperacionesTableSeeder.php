<?php

use App\Models\Activos\Activo;
use App\Models\Broker;
use App\Models\Operaciones\Compra;
use App\Models\Operaciones\Deposito;
use App\Models\Operaciones\Venta;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
                $this->agregarRegistro($dato);
            }
        }
    }

    public function agregarRegistro($dato)
    {
        $fecha = trim($dato['A']);

        if (! (strlen($fecha) == 10))
            return;

        $fecha = Carbon::createFromFormat("d/m/Y H:i:s", $fecha . ' 00:00:00');

        $descripcion = trim($dato['B']);

        if ($descripcion == 'Ingreso de Fondos')
        {
            Deposito::create([
                'fecha' => $fecha,
                'importe' => $this->tofloat($dato['E'])
            ]);
        };

        if (Str::startsWith($descripcion, 'COMPRA'))
        {
            $partes = explode(' ', $descripcion);

            if (count($partes) == 2)
            {
                $ticker = trim($partes[1]);

                $activo = Activo::byTicker($ticker);

                if ($activo) {

                    $cantidad = $this->tofloat($dato['C']);

                    $precio = $this->tofloat($dato['D']);

                    $importe = $this->tofloat($dato['E']);

                    $importeCalculado = $precio * $cantidad;

                    $diferencia = abs($importeCalculado - $importe);

                    if ($diferencia > 20)
                    {
                        Compra::create([
                            'fecha' => $fecha,
                            'activo_id' => $activo ? $activo->id : null,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'importe' => $diferencia
                        ]);
                    }
                }
            }
        }

        if (Str::startsWith($descripcion, 'VENTA'))
        {
            $partes = explode(' ', $descripcion);

            if (count($partes) == 2)
            {
                $ticker = trim($partes[1]);

                $activo = Activo::byTicker($ticker);

                if ($activo) {
                    Venta::create([
                        'fecha' => $fecha,
                        'activo_id' => $activo ? $activo->id : null,
                        'cantidad' => $this->tofloat($dato['C']),
                        'precio' => $this->tofloat($dato['D']),
                        'importe' => $this->tofloat($dato['E'])
                    ]);
                }
            }
        }
    }
}
