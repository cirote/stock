<?php

namespace App\Models\Exchanges;

use ccxt\okex as baseOkex;

class okex extends baseOkex
{
    protected $datos_brutos;
    public $mercados;

	public static function create()
	{
		$exchange = new static([
			'apiKey' => env('OKEX_API_KEY'),
			'secret' => env('OKEX_SECRET')
		]);

		return $exchange;
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
		$market1 = Market::create($this, $entre, $y);
		$market2 = Market::create($this, $y, $atravesDe);
		$market3 = Market::create($this, $atravesDe, $entre);

//		dump($market1);
//		dump($market1->bid);
//		dump($market1->ask);

		$e1 = $market1->convertir();
		$e2 = $market2->convertir($e1);
		$e3 = $market3->convertir($e2);

		if ($e3 > 1) {
            echo "\nOportunidades de arbitraje entre $entre y $y a traves de $atravesDe \n\n";
            echo "Convierto 1 $entre en $e1 $y \n";
			echo "Convierto $e1 $y en $e2 $atravesDe \n";
			echo "Convierto $e2 $atravesDe en $e3 $entre \n";
		}
	}

	public function fetch_exchange_info()
	{
		$url = 'https://www.okex.com/api/spot/v3/instruments/ticker';

		$this->datos_brutos = json_decode(file_get_contents($url));
	}

    public function fetch_mercados()
    {
        $this->mercados = [];

        foreach ($this->datos_brutos as $dato) {

            list($entre, $y) = explode('-', $dato->instrument_id);

            $ticker = "$entre/$y";

            $this->mercados[$ticker] = [
                'quote' => $entre,
                'base' => $y,
                'bid' => $dato->best_bid * 1.0,
                'ask' => $dato->best_ask * 1.0,
            ];
        }
    }

    public function getMMercadosAttribute() {
	    return $this->mercados;
    }
}
