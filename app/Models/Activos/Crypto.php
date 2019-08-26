<?php

namespace App\Models\Activos;

use App\Models\Mercados\Mercado;
use Tightenco\Parental\HasParent;

class Crypto extends Moneda
{
    private $mercado;

    public function mercado(Moneda $base)
    {
        if (!$this->mercado)
            $this->mercado = new Mercado($this, $base);

        return $this->mercado;
    }
}
