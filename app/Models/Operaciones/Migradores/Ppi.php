<?php

namespace App\Models\Operaciones\Migradores;

use App\Models\Activos\Activo;
use App\Models\Activos\Moneda;
use App\Models\Operaciones\Compra;
use App\Models\Operaciones\Deposito;
use App\Models\Operaciones\EjercicioVendedor;
use App\Models\Operaciones\Venta;
use App\Models\Operaciones\ComisionCompraVenta;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Ppi extends Base
{
    protected function fecha()
    {
        $fecha = trim($this->datos['A']);

        if (! (strlen($fecha) == 10))
            return null;

        return Carbon::createFromFormat("d/m/Y H:i:s", $fecha . ' 00:00:00');
    }

    protected function descripcion()
    {
        return trim($this->datos['B']);
    }

    protected function precio()
    {
        return $this->tofloat($this->datos['D']);
    }

    protected function cantidad()
    {
        return $this->tofloat($this->datos['C']);
    }

    protected function monedaUsadaPeso()
    {
        if (Str::startsWith($this->planilla, 'Dolar'))
        {
            return false;
        }

        return true;
    }

    protected function pesos()
    {
        return $this->monedaUsadaPeso()
            ? $this->tofloat($this->datos['E'])
            : $this->dolares() * Moneda::cotizacion($this->fecha());
    }

    protected function dolares()
    {
        return $this->monedaUsadaPeso()
            ? $this->pesos() / Moneda::cotizacion($this->fecha())
            : $this->tofloat($this->datos['E']);
    }

    protected function aportes()
    {
        if ($this->descripcion() == 'Ingreso de Fondos') {
            Deposito::create([
                'fecha'   => $this->fecha(),
                'pesos'   => $this->pesos(),
                'dolares' => $this->dolares(),
                'broker_id' => $this->broker->id
            ]);
        };
    }

    protected function compras()
    {
        $this->compra_venta('COMPRA', Compra::class);
    }

    protected function ventas()
    {
        $this->compra_venta('VENTA', Venta::class);
    }

    protected function compra_venta($leyenda, $clase)
    {
        if (Str::startsWith($this->descripcion(), $leyenda))
        {
            $partes = explode(' ', $this->descripcion());

            if (count($partes) == 2)
            {
                $ticker = trim($partes[1]);

                $activo = Activo::byTicker($ticker);

                if ($activo) {

                    if ($this->monedaUsadaPeso())
                    {
                        $importeCalculado = $this->precio() * $this->cantidad();

                        $diferencia = abs($importeCalculado - $this->pesos());

                        $porcentual = $diferencia / $this->pesos();
                    }

                    else
                    {
                        $porcentual = 0;
                    }

                    if ($porcentual < 0.1)
                    {
                        $clase::create([
                            'fecha'     => $this->fecha(),
                            'activo_id' => $activo->id,
                            'cantidad'  => $this->cantidad(),
                            'precio'    => $this->precio(),
                            'pesos'     => $this->pesos(),
                            'dolares'   => $this->dolares(),
                            'broker_id' => $this->broker->id
                        ]);
                    }

                    else 
                    {
                         ComisionCompraVenta::create([
                            'fecha'     => $this->fecha(),
                            'activo_id' => $activo->id,
                            'cantidad'  => 0,
                            'precio'    => 0,
                            'pesos'     => $this->pesos(),
                            'dolares'   => $this->dolares(),
                            'broker_id' => $this->broker->id
                        ]);                       
                    }
                }

                else {

                    echo("El ticker [$ticker] no existe en la base de datos \n");
                }
            }
        }
    }

    protected function ejercicioVendedor()
    {
        if (Str::startsWith($this->descripcion(), 'Boleto'))
        {
            $partes = explode(' / ', $this->descripcion());

            if ((count($partes) == 6) AND ($partes[2] == 'EJERCLAN'))
            {
                $tickerOpcion = trim($partes[4]);

                $ticker = substr($tickerOpcion, 0, 3);

                $activo = Activo::byTicker($ticker);

                if ($activo)
                {
                    EjercicioVendedor::create([
                        'fecha'     => $this->fecha(),
                        'activo_id' => $activo->id,
                        'cantidad'  => $this->cantidad(),
                        'precio'    => $this->precio(),
                        'pesos'     => $this->pesos(),
                        'dolares'   => $this->dolares(),
                        'broker_id' => $this->broker->id
                    ]);
                }
            }
        }
    }
}
