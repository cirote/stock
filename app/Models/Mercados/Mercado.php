<?php

namespace App\Models\Mercados;

use App\Models\Activos\{Activo, Monedas\Moneda};
use Illuminate\Database\Eloquent\Model;

class Mercado extends Model
{
    protected $activo;
    protected $base;

    public function __construct(Activo $activo, Moneda $base)
    {
        $this->activo = $activo;
        $this->base = $base;
    }

    public function getPairAttribute()
    {
        return "{$this->activo->ticker}-{$this->base->ticker}";
    }

    private $orderBook;

    public function getOrderBookAttribute()
    {
        if (!$this->orderBook)
            $this->orderBook = new OrderBook($this);

        return $this->orderBook;
    }

    public function getActivoAttribute()
    {
        return $this->activo;
    }

    public function getBaseAttribute()
    {
        return $this->base;
    }
}