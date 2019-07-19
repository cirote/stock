<?php

namespace App\Models\Mercados;

use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    protected $attributes;

    public function __construct(array $attributes)
    {
        // parent::__construct($attributes);

        $this->attributes = $attributes;
    }

    public function getPrecioAttribute()
    {
        return $this->attributes[0] * 1.0;
    }

    public function getCantidadAttribute()
    {
        return $this->attributes[1] * 1.0;
    }
}