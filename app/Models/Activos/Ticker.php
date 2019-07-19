<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    protected function activo()
    {
        return $this->belongsTo(Activo::class);
    }
}
