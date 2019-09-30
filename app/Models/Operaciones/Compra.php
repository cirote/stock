<?php

namespace App\Models\Operaciones;

use Tightenco\Parental\HasParent;

class Compra extends Operacion
{
    use HasParent;

    public function getDescripcionAttribute()
    {
        return 'Compra';
    }
}
