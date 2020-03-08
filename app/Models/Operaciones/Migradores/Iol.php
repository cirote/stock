<?php

namespace App\Models\Operaciones\Migradores;

use App\Models\Activos\Activo;
use App\Models\Activos\Moneda;
use App\Models\Operaciones\Compra;
use App\Models\Operaciones\Retiro;
use App\Models\Operaciones\Deposito;
use App\Models\Operaciones\EjercicioVendedor;
use App\Models\Operaciones\Venta;
use App\Models\Operaciones\ComisionCompraVenta;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Iol extends Base
{
    protected function fecha()
    {
        $fecha = trim($this->datos['E']);

        if (! (strlen($fecha) == 8))
            return null;

        return Carbon::createFromFormat("d/m/y H:i:s", $fecha . ' 00:00:00');
    }

    protected function descripcion()
    {
        return trim($this->datos['C']);
    }

    protected function precio()
    {
        return $this->tofloat($this->datos['H']);
    }

    protected function cantidad()
    {
        return $this->tofloat($this->datos['G']);
    }

    protected function tipoDeCuenta()
    {
        return trim($this->datos['N']);
    }

    protected function monedaUsadaPeso()
    {
        if (Str::startsWith($this->tipoDeCuenta(), 'Inversion Argentina Dolares'))
        {
            return false;
        }

        return true;
    }

    protected function pesos()
    {
        return $this->monedaUsadaPeso()
            ? $this->tofloat($this->datos['L'])
            : $this->dolares() * Moneda::cotizacion($this->fecha());
    }

    protected function dolares()
    {
        return $this->monedaUsadaPeso()
            ? $this->pesos() / Moneda::cotizacion($this->fecha())
            : $this->tofloat($this->datos['L']);
    }

    protected function aportes()
    {
        if (Str::startsWith($this->descripcion(), 'Depósito de Fondos')) 
        {
            Deposito::create([
                'fecha'   => $this->fecha(),
                'pesos'   => $this->pesos(),
                'dolares' => $this->dolares(),
                'broker_id' => $this->broker->id
            ]);
        };
    }

    protected function retiros()
    {
        if (Str::startsWith($this->descripcion(), 'Extracción de Fondos')) 
        {
            Retiro::create([
                'fecha'   => $this->fecha(),
                'pesos'   => $this->pesos(),
                'dolares' => $this->dolares(),
                'broker_id' => $this->broker->id
            ]);
        };
    }

    protected function compras()
    {
        $this->compra_venta('Compra(', Compra::class);
    }

    protected function ventas()
    {
        $this->compra_venta('Venta(', Venta::class);
    }

    protected function compra_venta($leyenda, $clase)
    {
        if (Str::startsWith($this->descripcion(), $leyenda))
        {
            $ticker = $this->nombreTicker($this->descripcion());

            if ($ticker)
            {
                $activo = Activo::byTicker($ticker);

                if ($activo) 
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
                    echo("El ticker [$ticker] no existe en la base de datos \n");
                }
            }

            else
            {
                echo("La descripcion [{$this->descripcion()}] no es interpretable \n");
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

    protected function suscripcion()
    {
        if (Str::startsWith($this->descripcion(), 'Extracción bb de Fondos')) 
        {
            $ticker = $this->nombreTicker($this->descripcion());

            $activo = Activo::byTicker($ticker);

            if ($activo)
            {
                Suscripcion::create([
                    'fecha'     => $this->fecha(),
                    'activo_id' => $activo->id,
                    'cantidad'  => $this->cantidad(),
                    'precio'    => $this->pesos() / $this->cantidad(),
                    'pesos'     => $this->pesos(),
                    'dolares'   => $this->dolares(),
                    'broker_id' => $this->broker->id
                ]);
            }
        }
    }

    protected function nombreTicker($nombre)
    {
        $posInicial = strpos($nombre, '(');

        if ($posInicial === false) 
        {
            $ticker = null;
        } 

        else 
        {
            $posFinal = strpos($nombre, ')');

            if ($posFinal === false) 
            {
                $ticker = null;
            } 

            else
            {
                $ticker = substr($nombre, $posInicial + 1, $posFinal - 1 - $posInicial);
            }
        }

        return $ticker;
    }
}
