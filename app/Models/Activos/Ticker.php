<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    static public function byName($name)
    {
        return static::where('ticker', $name)->first();
    }

    protected function activo()
    {
        return $this->belongsTo(Activo::class);
    }
}
