<?php

namespace App\Http\Controllers;

use App\Models\Activos\Activo;
use App\Models\Activos\Moneda;

class StockController extends Controller
{
	public function index()
    {
        return view('activo.index')
            ->withActivos(Activo::conStock());
    }

    public function anteriores()
    {
        return view('activo.sinStock')
            ->withActivos(Activo::sinStock());
    }

    public function mayor(Activo $activo)
    {
        return view('activo.mayor')
            ->withActivo($activo);
    }

    public function ccl(Activo $activo)
    {
        //dd($activo->historico());

        //dd(Moneda::cotizacion('2019-09-05'));

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
