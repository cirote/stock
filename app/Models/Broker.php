<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Operaciones\Operacion;
use App\Models\Operaciones\Deposito;
use App\Models\Operaciones\Retiro;

class Broker extends Model
{
    static public function byName($name)
    {
        return static::where('nombre', $name)->first();
    }

    static public function bySigla($sigla)
    {
        return static::where('sigla', $sigla)->first();
    }

    public function operaciones()
    {
        return $this->hasMany(Operacion::class, 'broker_id')
        	->whereIn('type', [Deposito::class, Retiro::class])
        	->orderByDesc('fecha');
    }


    private $aportes_netos;

    public function getAportesNetosAttribute()
    {
        if (! $this->aportes_netos)
        {
            $this->aportes_netos = 0;

            foreach ($this->operaciones as $operacion)
            {
                if ($operacion instanceof Deposito)
                {
                    $this->aportes_netos += $operacion->dolares;
                }

                if ($operacion instanceof Retiro)
                {
                    $this->aportes_netos -= $operacion->dolares;
                }
            }
        }

        return $this->aportes_netos;
    }


}
