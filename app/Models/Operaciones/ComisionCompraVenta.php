<?php

namespace App\Models\Operaciones;

use Tightenco\Parental\HasParent;

class ComisionCompraVenta extends Operacion
{
    use HasParent;

    public function getDescripcionAttribute()
    {
        return 'ComisionCompraVenta';
    }
}
