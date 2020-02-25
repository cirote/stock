<?php

namespace App\Models\Operaciones\Migradores;

use App\Models\Broker;

abstract class Base
{
    protected $datos;

    protected $broker;

    protected $planilla;

    public static function Migrate($datos, $planilla, broker $broker)
    {
        return new static($datos, $planilla, $broker);
    }

    public function __construct($datos, $planilla, broker $broker)
    {
        $this->datos = $datos;

        $this->broker = $broker;

        $this->planilla = trim($planilla);

        if ($this->fecha())
            $this->agregarRegistro();
    }

    protected function agregarRegistro()
    {
        $this->aportes();
        $this->retiros();
        $this->compras();
        $this->ventas();
        $this->ejercicioVendedor();
    }

    abstract protected function fecha();

    abstract protected function aportes();

    abstract protected function retiros();

    abstract protected function compras();

    abstract protected function ventas();

    abstract protected function ejercicioVendedor();

    protected function tofloat($num)
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
