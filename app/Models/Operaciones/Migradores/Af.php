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

class Af extends Base
{
    protected function fecha()
    {
        $fecha = trim($this->datos['B']);

        if (! (strlen($fecha) == 10))
            return null;

        if (!$this->pesos())
        	return null;

        return Carbon::createFromFormat("d/m/Y H:i:s", $fecha . ' 00:00:00');
    }

    protected function descripcion()
    {
        return trim($this->datos['N']);
    }

    protected function precio()
    {
        return null;
    }

    protected function cantidad()
    {
        return null;
    }

    protected function pesos()
    {
        return $this->tofloat($this->datos['L']);
    }

    protected function dolares()
    {
        return $this->pesos() / Moneda::cotizacion($this->fecha());
    }

    protected function aportes()
    {
        if (!Str::startsWith($this->descripcion(), 'Retiro'))
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
        if (Str::startsWith($this->descripcion(), 'Retiro'))
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

    }

    protected function ventas()
    {

    }

    protected function ejercicioVendedor()
    {

    }

    protected function suscripcion()
    {

    }

    protected function nombreTicker($nombre)
    {

    }
}

