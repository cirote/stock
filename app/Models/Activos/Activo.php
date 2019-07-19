<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Tightenco\Parental\HasChildren;

class Activo extends Model
{
    static public function byName($name)
    {
        return static::where('nombre', $name)->first();
    }

    use HasChildren;

    protected $fillable = ['type'];

    public function tickers()
    {
        return $this->hasMany(Ticker::class, 'activo_id');
    }

    public function getTickerAttribute()
    {
        return $this->tickers()->first()->ticker;
    }
}