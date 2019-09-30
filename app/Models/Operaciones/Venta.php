<?php

namespace App\Models\Operaciones;

use Tightenco\Parental\HasParent;

class Venta extends Operacion
{
    use HasParent;

    public function getDescripcionAttribute()
    {
        return 'Venta';
    }
}
