<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Tightenco\Parental\HasChildren;

class Activo extends Model
{
    use HasChildren;

    protected $fillable = ['type'];

    static public function byName($name)
    {
        return static::where('denominacion', $name)->first();
    }

    /*
     * Funciones con tickers
     */
    static public function byTicker($ticker)
    {
        return Ticker::byName($ticker)->activo;
    }

    public function tickers()
    {
        return $this->hasMany(Ticker::class, 'activo_id');
    }

    public function agregarTicker($ticker)
    {
        $this->tickers()->create([
            'ticker' => $ticker
        ]);

        return $this;
    }

    public function getTickerAttribute()
    {
        return $this->tickers()->first()->ticker;
    }

    /*
     * Funciones con las bolsas
     */




}
