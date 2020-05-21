<?php

namespace Cirote\Opciones\Actions;

use Carbon\Carbon;

class CalcularVencimientoOpcionAction
{
    public function execute(string $ticker, $fechaDeLaOperacion = null): Carbon
    {
        $fecha = $this->getFecha();

        $fecha->month = $this->getMes($ticker);

        return new Carbon('third friday of ' . $fecha->format('F') . ' ' . $this->getAno($ticker, $fechaDeLaOperacion));
    }

    private function getAno(string $ticker, $fechaDeLaOperacion = null): int
    {
        $fecha = $this->getFecha($fechaDeLaOperacion);

        return $fecha->year + ($fecha->month > $this->getMesFromSigla($this->getSiglaMes($ticker)));
    }

    private function getFecha($fecha = null): Carbon
    {
        if ($fecha instanceof Carbon)
        {
            return $fecha;
        }

        if (! $fecha)
        {
            return Carbon::now();
        }

        return Carbon::createFromFormat('d/m/Y', $fecha);
    }

    private function getMes(string $ticker): int
    {
        return $this->getMesFromSigla($this->getSiglaMes($ticker));
    }

    private function getSiglaMes(string $ticker): string
    {
        return substr($ticker, 8, 2);
    }

    private function getMesFromSigla(string $mes): int
    {
        return [
            'MY' => 5,
            'JU' => 6,
            'AG' => 8
        ][$mes] ?? null;
    }}
