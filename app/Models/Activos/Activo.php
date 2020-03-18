<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Tightenco\Parental\HasChildren;
use App\Models\Broker;
use App\Models\Operaciones\Compra;
use App\Models\Operaciones\EjercicioVendedor;
use App\Models\Operaciones\Operacion;
use App\Models\Operaciones\Venta;
use App\Models\Operaciones\ComisionCompraVenta;
use App\Models\Operaciones\Suscripcion;

class Activo extends Model
{
    use HasChildren;

    protected $fillable = ['type', 'denominacion', 'clase'];

    static public function byName($name)
    {
        return static::where('denominacion', $name)->first();
    }

    static public function conStock()
    {
        return static::orderBy('denominacion')->get()->filter(function ($value, $key) 
        {
            return $value->cantidad;
        });
    }

    static public function sinStock()
    {
        return static::orderBy('denominacion')->get()->filter(function ($value, $key) 
        {
            return !$value->cantidad;
        });
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

    public function broker()
    {
        if ($this->broker_id)
            return $this->belongsTo(Broker::class);
    }

    public function operaciones()
    {
        if ($this->broker_id)
        {
            return $this->hasMany(Operacion::class, 'activo_id')
                ->where('broker_id', $this->broker_id)
                ->orderBy('fecha');
        }

        return $this->hasMany(Operacion::class, 'activo_id')->orderBy('fecha');
    }

    private $cantidad_de_activos;

    public function getCantidadAttribute()
    {
        if (! $this->cantidad_de_activos)
        {
            $this->cantidad_de_activos = 0;

            foreach ($this->operaciones as $operacion)
            {
                if ($operacion instanceof Compra)
                {
                    $this->cantidad_de_activos += $operacion->cantidad;
                }

                if ($operacion instanceof Suscripcion)
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

    private $costo_de_los_activos;

    public function getCostoAttribute()
    {
        if (! $this->costo_de_los_activos)
        {
            $this->costo_de_los_activos = 0;

            foreach ($this->operaciones as $operacion)
            {
                if ($operacion instanceof Compra)
                {
                    $this->costo_de_los_activos += $operacion->dolares;
                }

                if ($operacion instanceof Suscripcion)
                {
                    $this->costo_de_los_activos += $operacion->dolares;
                }

                if ($operacion instanceof Venta)
                {
                    $this->costo_de_los_activos -= $operacion->dolares;
                }

                if ($operacion instanceof EjercicioVendedor)
                {
                    $this->costo_de_los_activos -= $operacion->dolares;
                }

                if ($operacion instanceof ComisionCompraVenta)
                {
                    $this->costo_de_los_activos += $operacion->dolares;
                }
            }
        }

        return $this->costo_de_los_activos;
    }


}
