<?php

namespace App\Http\Controllers;

use App\Models\Broker;

class BrokerController extends Controller
{
	public function index()
    {
        return view('broker.index')
            ->withBrokers(Broker::with('operaciones')->get());
    }

	public function aportes(Broker $broker)
    {
        return view('activo.aportes')
            ->withBroker($broker);
    }
}
