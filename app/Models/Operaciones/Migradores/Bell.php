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
use App\Models\Operaciones\Suscripcion;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Bell extends Base
{
    protected function fecha()
    {
        $fecha = trim($this->datos['B']);

        if (! (strlen($fecha) == 8))
            return null;

        if ($fecha == 'Concepto')
            return null;
        
        return Carbon::createFromFormat("d/m/y H:i:s", $fecha . ' 00:00:00');
    }

    protected function descripcion()
    {
        return trim($this->datos['F']);
    }

    protected function operacion()
    {
        return trim($this->datos['D']);
    }

    protected function precio()
    {
        return $this->tofloat($this->datos['H']);
    }

    protected function cantidad()
    {
        return $this->tofloat($this->datos['G']);
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
            ? $this->tofloat($this->datos['I'])
            : $this->dolares() * Moneda::cotizacion($this->fecha());
    }

    protected function dolares()
    {
        return $this->monedaUsadaPeso()
            ? $this->pesos() / Moneda::cotizacion($this->fecha())
            : $this->tofloat($this->datos['I']);
    }

    protected function aportes()
    {
        if ($this->operacion() == 'COBR') {
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
        if ($this->descripcion() == 'Retiro de Fondos') {
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
        if ($this->monedaUsadaPeso())
        {
            $this->compra_venta('CPRA', Compra::class);
        }

        if (! $this->monedaUsadaPeso())
        {
            $this->compra_venta('CPU$', Compra::class);
        }
    }

    protected function ventas()
    {
        $this->compra_venta('VTAS', Venta::class);
    }

    protected function compra_venta($leyenda, $clase)
    {
        if ($this->operacion() == $leyenda) 
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
                echo("Descripcion [{$this->descripcion()}] no interpretable \n");
            }
        }
    }

    protected function ejercicioVendedor()
    {
        if ($this->operacion() == 'EJPV') 
        {
            $ticker = $this->nombreTicker($this->descripcion());

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

    protected function suscripcion()
    {
        if ($this->operacion() == 'SUSC') 
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
        if (strlen($this->descripcion()) == 4)
        {
            $ticker = $this->descripcion();
        }

        else
        {
            switch ($nombre)
            {
                case 'PHOENIX GLOBAL RESOURCES PLC. ORD SHS':

                    $ticker = 'PGR';

                    break;

                case 'TERNIUM ARG S.A.ORDS. A 1 VOTO ESC':

                    $ticker = 'TXAR';

                    break;

                case 'CARBOCLOR SA':

                    $ticker = 'CARC';

                    break;

                case 'BANCO SANTANDER C.H.':

                    $ticker = 'SAN';

                    break;

                case 'GRUPO SUPERVIELLE ACC.ORD. "B" 1':

                    $ticker = 'SUPV';

                    break;

                case 'YPF S.A.':

                    $ticker = 'YPFD';

                    break;

                case 'BONO REP ARGENTINA 7,125% 28/06/2117':

                    $ticker = 'AC17';

                    break;

                case 'BPLD - PROV BSAS 2035 4% USD':

                    $ticker = 'BPLD';

                    break;

                case 'DICA BONO DISCOUNT U$S 8,28% 2033':

                    $ticker = 'DICA';

                    break;

                case 'DICY BONO DISCOUNT U$S 8,28% 2033':

                    $ticker = 'DICY';

                    break;

                case 'TVPA VAL.NEG. PBI 2035':

                    $ticker = 'TVPA';

                    break;

                default:

                    $ticker = null;

                    break;
            }
        }

        return $ticker;
    }
}
