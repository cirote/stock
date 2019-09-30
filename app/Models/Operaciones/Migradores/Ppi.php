<?php

namespace App\Models\Operaciones\Migradores;

use App\Models\Activos\Activo;
use App\Models\Operaciones\Compra;
use App\Models\Operaciones\Deposito;
use App\Models\Operaciones\EjercicioVendedor;
use App\Models\Operaciones\Venta;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Ppi extends Base
{
    public static function Migrate($dato)
    {
        return new static($dato);
    }

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

    protected function importe()
    {
        return $this->tofloat($this->datos['E']);
    }

    protected function aportes()
    {
        if ($this->descripcion() == 'Ingreso de Fondos') {
            Deposito::create([
                'fecha'   => $this->fecha(),
                'importe'   => $this->importe()
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

                    $importeCalculado = $this->precio() * $this->cantidad();

                    $diferencia = abs($importeCalculado - $this->importe());

                    $porcentual = $diferencia / $this->importe();

                    if ($porcentual < 0.1)
                    {
                        $clase::create([
                            'fecha'     => $this->fecha(),
                            'activo_id' => $activo ? $activo->id : null,
                            'cantidad'  => $this->cantidad(),
                            'precio'    => $this->precio(),
                            'importe'   => $this->importe()
                        ]);
                    }
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
                        'activo_id' => $activo ? $activo->id : null,
                        'cantidad'  => $this->cantidad(),
                        'precio'    => $this->precio(),
                        'importe'   => $this->importe()
                    ]);
                }
            }
        }
    }
}
