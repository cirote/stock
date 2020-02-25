<?php

namespace App\Models\Operaciones;

use Tightenco\Parental\HasParent;

class Retiro extends Operacion
{
    use HasParent;

    public function getDescripcionAttribute()
    {
        return 'Retiro';
    }
}
