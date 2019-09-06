<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;

class Mercado extends Model
{
    static public function byName($name)
    {
        return static::where('nombre', $name)->first();
    }

    public function bolsa()
    {
        return $this->belongsTo(Bolsa::class);
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function activos()
    {
        return $this->belongsToMany(Activo::class);
    }
}
