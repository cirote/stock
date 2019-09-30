<?php

namespace App\Models\Activos;

use App\Models\Operaciones\Compra;
use App\Models\Operaciones\EjercicioVendedor;
use App\Models\Operaciones\Operacion;
use App\Models\Operaciones\Venta;
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
        $tickerGuardado = Ticker::byName($ticker);

        if ($tickerGuardado)
            return $tickerGuardado->activo;

        return null;
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

    public function operaciones()
    {
        return $this->hasMany(Operacion::class, 'activo_id')->orderBy('fecha');
    }

    private $cantidad_de_activos;

    public function getCantidadAttribute()
    {
        static $cantidad_de_activos = 0;

        if (! $this->cantidad_de_activos)
        {
            $this->cantidad_de_activos = 0;

            foreach ($this->operaciones as $operacion)
            {
                if ($operacion instanceof Compra)
                {
                    $this->cantidad_de_activos += $operacion->cantidad;
                }

                if ($operacion instanceof Venta)
                {
                    $this->cantidad_de_activos -= $operacion->cantidad;
                }

                if ($operacion instanceof EjercicioVendedor)
                {
                    $this->cantidad_de_activos -= $operacion->cantidad;
                }

            }
        }

        return $this->cantidad_de_activos;
    }


}
