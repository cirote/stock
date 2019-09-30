<?php

namespace App\Models\Operaciones\Migradores;

abstract class Base
{
    protected $datos;

    public function __construct($datos)
    {
        $this->datos = $datos;

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
