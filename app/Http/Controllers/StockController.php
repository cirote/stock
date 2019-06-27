<?php

namespace App\Http\Controllers;

use App\Models\Exchanges\okex;

class StockController extends Controller
{
	public function index()
    {
    	$exchange = Okex::create();

    	$entre = 'USDT';
    	$y = 'ETH';
		$exchange->arbitrar($entre, $y);

	    die();
    }
}
