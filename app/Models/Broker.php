<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
