<?php

namespace App\Models\Exchanges;

use ccxt\okex as baseOkex;
use Illuminate\Support\Arr;

class Okex extends baseOkex
{
    protected $datos_brutos;
    public $mercados;

	public static function create()
	{
		return new static([
			'apiKey' => env('OKEX_API_KEY'),
			'secret' => env('OKEX_SECRET')
		]);
	}

	public function arbitrage_options($entre = 'BTC', $y = 'ETH')
	{
		return $this->currency_trade($entre)
			->intersect($this->currency_trade($y));
	}

	public function currency_trade(string $currency)
	{
		$currencies = array_merge(
			collect($this->mercados)->where('quote', $currency)->pluck('base')->all(),
			collect($this->mercados)->where('base', $currency)->pluck('quote')->all()
		);

		sort($currencies);

		return collect($currencies)->unique();
	}

	public function currencies()
	{
		$currencies = array_merge(
			collect($this->mercados)->pluck('base')->all(),
			collect($this->mercados)->pluck('quote')->all()
		);

		sort($currencies);

		return collect($currencies)->unique()->all();
	}

	public function refer_currencies()
	{
		return ['BTC', 'ETH', 'USDT', 'USDK', 'OKB'];
	}

	public function arbitrar($entre, $y)
	{
		foreach ($this->arbitrage_options($entre, $y) as $atravesDe) {
		    $this->arbitrajeEspejo($entre, $y, $atravesDe);
		}
	}

	public function arbitrajeEspejo($entre, $y, $atravesDe)
	{
		$this->arbitraje($entre, $y, $atravesDe);

		$this->arbitraje($y, $entre, $atravesDe);
	}

	public function arbitraje($entre, $y, $atravesDe)
	{
		if (! $market1 = Market::create($this, $entre, $y))
			return;
		if (! $market2 = Market::create($this, $y, $atravesDe))
			return;
		if (! $market3 = Market::create($this, $atravesDe, $entre))
			return;

//		dump($market1);
//		dump($market1->bid);
//		dump($market1->ask);

		$e1 = $market1->convertir();
		$e2 = $market2->convertir($e1);
		$e3 = $market3->convertir($e2);

		if ($e3 >= 1.001) {
            echo "\nOportunidades de arbitraje entre $entre y $y a traves de $atravesDe \n";
            echo " - Convierto 1 $entre en $e1 $y \n";
			echo " - Convierto $e1 $y en $e2 $atravesDe \n";
			echo " - Convierto $e2 $atravesDe en $e3 $entre \n";
		}
	}

	public function fetch_markets_info()
	{
		$url = 'https://www.okex.com/api/spot/v3/instruments/ticker';

		return json_decode(file_get_contents($url));
	}

    public function get_mercados()
    {
        $this->mercados = [];

        foreach ($this->fetch_markets_info() as $market) {

            list($entre, $y) = explode('-', $market->instrument_id);

            $ticker = "$entre/$y";

            $this->mercados[$ticker] = [
                'activo' => $entre,
                'base' => $y,
                'bid' => $market->best_bid * 1.0,
                'ask' => $market->best_ask * 1.0,
            ];
        }

        return $this->mercados;
    }

    public function bases()
    {
	    return array_unique(Arr::pluck($this->get_mercados(), 'base'));
    }

	public function activos($base)
	{
		$filtered = Arr::where($this->get_mercados(), function ($value) use ($base) {
			return $value['base'] == $base;
		});

		return array_unique(Arr::pluck($filtered, 'activo'));
	}

}
