<?php

namespace App\Http\Controllers;

use App\Models\Exchanges\okex;

class StockController extends Controller
{
	public function index()
    {
    	$exchange = Okex::create();

    	var_dump($exchange->fetch_exchange_info());

    	die;
    	$entre = 'USDT';
    	$y = 'ETH';
		$exchange->arbitrar($entre, $y);

	    die();
    }
}
