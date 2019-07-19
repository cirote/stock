<?php

namespace App\Models\Activos\CriptoMonedas;

use App\Models\Activos\Monedas\Moneda;
use App\Models\Mercados\Mercado;
use Tightenco\Parental\HasParent;

class Cripto extends Moneda
{
    use HasParent;

    private $mercado;

    public function mercado(Moneda $base)
    {
        if (!$this->mercado)
            $this->mercado = new Mercado($this, $base);

        return $this->mercado;
    }
}
