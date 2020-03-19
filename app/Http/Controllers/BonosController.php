<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use App\Models\Activos\Bono;
use App\Models\Activos\Moneda;

class BonosController extends Controller
{
	public function index()
    {
        return view('activo.index')
            ->withTitulo('Total de Bonos con stock')
            ->withActivos(Bono::conStock());
    }
}