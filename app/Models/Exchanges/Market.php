<?php

namespace App\Models\Exchanges;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
	public static function create($exchange, $entre, $y)
	{
		return new static($exchange, $entre, $y);
	}

	protected $exchange;
	protected $entre;
	protected $y;
	protected $invertido;
	protected $symbol;

	public function __construct($exchange, $entre, $y)
	{
		$this->exchange = $exchange;
		$this->entre = $entre;
		$this->y = $y;

		$this->symbol = "$entre/$y";
		if (isset($this->exchange->markets[$this->symbol])) {
			$this->invertido = false;
		} else {
			$this->symbol = "$y/$entre";
			$this->invertido = true;
		}
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
		$ob = $this->orderBook;

		return $this->invertido
			? [
				1 / $ob['asks'][0][0],
				$ob['asks'][0][1] / $ob['asks'][0][0]
			]
			: $ob['bids'][0];
	}

	public function getAskAttribute()
	{
		$ob = $this->orderBook;

		return $this->invertido
			? [
				1 / $ob['bids'][0][0],
				$ob['bids'][0][1] / $ob['bids'][0][0]
			]
			: $this->ob['asks'][0];
	}

	public function convertir($cantidad = 1)
	{
		return $cantidad * $this->bid[0] * (1 - 0.0015);
	}
}