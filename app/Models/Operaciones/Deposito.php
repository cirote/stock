<?php

namespace App\Models\Operaciones;

use Tightenco\Parental\HasParent;

class Deposito extends Operacion
{
    use HasParent;

    public function getDescripcionAttribute()
    {
        return 'Aporte';
    }
}
