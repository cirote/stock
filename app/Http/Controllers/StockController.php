<?php

namespace App\Http\Controllers;

use ccxt\okex;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
    	$okex = new okex();

    	$okex->load_markets();

    	dd($okex);

    	die;

    }
}
