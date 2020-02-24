<?php

namespace App\Http\Controllers;

use App\Models\Broker;

class BrokerController extends Controller
{
	public function aportes(Broker $broker)
    {
        return view('activo.aportes')
            ->withBroker($broker);
    }
}
