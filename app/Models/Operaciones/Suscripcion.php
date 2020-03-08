<?php

namespace App\Models\Operaciones;

use Tightenco\Parental\HasParent;

class Suscripcion extends Operacion
{
    use HasParent;

    public function getDescripcionAttribute()
    {
        return 'Suscripcion';
    }
}
