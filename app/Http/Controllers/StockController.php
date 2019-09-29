<?php

namespace App\Http\Controllers;

use App\Models\Activos\Accion;
use App\Models\Activos\Activo;
use App\Models\Activos\Moneda;
use App\Models\Activos\Historico;
use App\Models\Bolsas\Okex;
use Illuminate\Support\Collection;

class StockController extends Controller
{
	public function index()
    {
        return view('home.index')
            ->withActivos(Activo::all());

        dd(Moneda::makePesosPorDolar()->get());
    }

    public function ccl(Activo $activo)
    {
        dd($activo->historico());

        return view('prueba')
            ->withActivo($activo);
    }

    public function sma(Activo $activo)
    {
        return view('prueba')
            ->withActivo($activo);
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
