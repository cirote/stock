<?php

namespace Cirote\Opciones\Actions;

use Cirote\Opciones\Actions\CalcularVencimientoOpcionActionCalcularVencimientoOpcionAction;

class CalcularTickerCompletoOpcionAction
{
    private $calcularVencimiento;

    public function __construct(CalcularVencimientoOpcionAction $calcularVencimiento)
    {
        $this->calcularVencimiento = $calcularVencimiento;
    }

    public function execute(string $ticker, $fechaDeLaOperacion = null): string
    {
        return $ticker . '_' . $this->calcularVencimiento->execute($ticker, $fechaDeLaOperacion)->year;
    }
}
