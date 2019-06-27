<?php

namespace App\Models\Exchanges;

use ccxt\okex as baseOkex;

class okex extends baseOkex
{
	public static function create()
	{
		$exchange = new static([
			'apiKey' => env('OKEX_API_KEY'),
			'secret' => env('OKEX_SECRET')
		]);

		$exchange->load_markets();

		return $exchange;
	}

	public function arbitrage_options($entre = 'BTC', $y = 'ETH')
	{
		return ['AAC', 'BTC'];
		return $this->currency_trade($entre)
			->intersect($this->currency_trade($y));
	}

	public function currency_trade(string $currency)
	{
		$currencies = array_merge(
			collect($this->markets)->where('quote', $currency)->pluck('base')->all(),
			collect($this->markets)->where('base', $currency)->pluck('quote')->all()
		);

		sort($currencies);

		return collect($currencies)->unique();
	}

	public function arbitrar($entre, $y)
	{
		$a = 0;

		foreach ($this->arbitrage_options($entre, $y) as $atravesDe) {
			if($a++ < 12)
			{
				$this->arbitrajeEspejo($entre, $y, $atravesDe);
			}
		}
	}

	public function arbitrajeEspejo($entre, $y, $atravesDe)
	{
		echo "Oportunidades de arbitraje entre $entre y $y a traves de $atravesDe <br><br>";

		$this->arbitraje($entre, $y, $atravesDe);

		$this->arbitraje($y, $entre, $atravesDe);
	}

	public function arbitraje($entre, $y, $atravesDe)
	{
		$market1 = Market::create($this, $entre, $y);
		$market2 = Market::create($this, $y, $atravesDe);
		$market3 = Market::create($this, $atravesDe, $entre);

//		dump($market1);
//		dump($market1->bid);
//		dump($market1->ask);

		$e1 = $market1->convertir();
		$e2 = $market2->convertir($e1);
		$e3 = $market3->convertir($e2);

		if ($e3 > 0) {
			echo "Convierto 1 $entre en $e1 $y <br>";
			echo "Convierto $e1 $y en $e2 $atravesDe <br>";
			echo "Convierto $e2 $atravesDe en $e3 $entre <br><br>";
		}
	}

	public function fetch_exchange_info()
	{
		$url = 'https://www.okex.com/api/spot/v3/instruments/ticker';

		return json_decode(file_get_contents($url), true);
	}
}
