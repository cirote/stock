<?php

namespace App\Models\Operaciones;

use Tightenco\Parental\HasParent;

class EjercicioVendedor extends Operacion
{
    use HasParent;

    public function getDescripcionAttribute()
    {
        return 'Venta por ejercicio de opciones';
    }
}
