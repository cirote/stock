<?php

namespace App\Models\Mercados;

use Illuminate\Database\Eloquent\Model;

class OrderBook extends Model
{
    protected $mercado;

    public function __construct(Mercado $mercado)
    {
        $this->mercado = $mercado;
    }

    public function getBidAttribute()
    {
        return new OrderInfo($this->getOrderBook()->bids[0]);
    }

    public function getAskAttribute()
    {
        return new OrderInfo($this->getOrderBook()->asks[0]);
    }

    private function url()
    {
        return "https://www.okex.com/api/spot/v3/instruments/{$this->mercado->pair}/book?size=1";
    }

    private function getOrderBook()
    {
        return json_decode(file_get_contents($this->url()));
    }




    private function getTodos()
    {
        $url = 'https://www.okex.com/api/spot/v3/instruments/ticker';

        return json_decode(file_get_contents($url));
    }

    public function getMercados()
    {
        $bids = [];
        $asks = [];
        $r = [];

        $activo = $this->mercado->activo->ticker;
        $base = $this->mercado->base->ticker;

        foreach ($this->getTodos() as $market) {

            list($entre, $y) = explode('-', $market->instrument_id);

            if ($y == $base) {
                $bids[$entre] = $market->best_bid * (1 - 0.0015);
            }

            if ($y == $activo) {
                $asks[$entre] = 1.0 / ($market->best_ask * (1 + 0.0015));
            }
        }

        foreach ($bids as $key => $value) {
            if (isset($asks[$key]))
                $r[$key] = $value * $asks[$key];
        }

        rsort($r);

        return $r;
    }
}