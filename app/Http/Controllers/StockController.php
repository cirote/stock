<?php

namespace App\Http\Controllers;

use App\Models\Exchanges\Okex;

class StockController extends Controller
{
	public function index()
    {

    	$exchange = Okex::create();

    	dd($exchange->activos('OKB'));

    	die;
    	$entre = 'USDT';
    	$y = 'ETH';
		$exchange->arbitrar($entre, $y);

	    die();
    }
}
