<?php

namespace App\Http\Controllers;

use App\Models\Activos\Moneda;
use App\Models\Activos\Historico;
use App\Models\Bolsas\Okex;

class StockController extends Controller
{
	public function index()
    {
        return view('prueba');

        dd(Moneda::makePesosPorDolar()->get());
    }

//    public function index()
//    {
//        $btc = Activo::byName('Tether');
//        $eth = Activo::byName('Ethereum');
//
//        $mercado = $eth->mercado($btc);
//
//        dump($mercado->orderBook->bid->precio);
//
//        dd($mercado->orderBook->getMercados());
//
//        $exchange = Okex::create();
//
//        dd($exchange->activos('OKB'));
//
//        die;
//        $entre = 'USDT';
//        $y = 'ETH';
//        $exchange->arbitrar($entre, $y);
//
//        die();
//    }
}
