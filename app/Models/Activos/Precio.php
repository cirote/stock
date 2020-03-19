<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
	public $fillable = ['ticker_id', 'mercado_id', 'moneda_id', 'bid_precio', 'bid_cantidad', 'ask_precio', 'ask_cantidad', 'precio_pesos', 'precio_dolares'];
}