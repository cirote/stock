<?php

namespace App\Models\Exchanges;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
	public static function create($exchange, $entre, $y)
	{
		$symbol = "$entre/$y";
		if (isset($exchange->mercados[$symbol])) {
			return new static($exchange, $entre, $y, $symbol, false);
		}
		$symbol = "$y/$entre";
		if (isset($exchange->mercados[$symbol])) {
			return new static($exchange, $entre, $y, $symbol, true);
		}

		return null;
	}

	protected $exchange;
	protected $entre;
	protected $y;
	protected $invertido;
	protected $symbol;

	public function __construct($exchange, $entre, $y, $symbol, $invertido)
	{
		$this->exchange = $exchange;
		$this->entre = $entre;
		$this->y = $y;
		$this->symbol = $symbol;
		$this->invertido = $invertido;
	}

	public function getSymbolAttribute()
	{
		return $this->symbol;
	}

	public function getOrderBookAttribute()
	{
		return $this->exchange->fetch_order_book($this->symbol, 1);
	}

	public function getBidAttribute()
	{
        $ob = $this->exchange->mercados;
        $ob = $ob[$this->symbol];

		return $this->invertido
			? $ob['ask'] ? 1 / $ob['ask'] : -1
			: $ob['bid'];
	}

	public function getAskAttribute()
	{
        $ob = $this->exchange->mercados;
        $ob = $ob[$this->symbol];

		return $this->invertido
			? $ob['bid'] ? 1 / $ob['bid'] : -1
			: $ob['ask'];
	}

	public function convertir($cantidad = 1)
	{
		return $cantidad * $this->bid * (1 - 0.0015);
	}
}