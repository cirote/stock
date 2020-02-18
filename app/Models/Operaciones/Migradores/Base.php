<?php

namespace App\Models\Operaciones\Migradores;

use App\Models\Broker;

abstract class Base
{
    protected $datos;

    protected $broker;

    public static function Migrate($datos, broker $broker)
    {
        return new static($datos, $broker);
    }

    public function __construct($datos, broker $broker)
    {
        $this->datos = $datos;

        $this->broker = $broker;

        if ($this->fecha())
            $this->agregarRegistro();
    }

    protected function agregarRegistro()
    {
        $this->aportes();
        $this->compras();
        $this->ventas();
        $this->ejercicioVendedor();
    }

    abstract protected function fecha();

    abstract protected function aportes();

    abstract protected function compras();

    abstract protected function ventas();

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
