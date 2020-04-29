<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use Cirote\Activos\Models\Bono;
use Cirote\Activos\Models\Moneda;

class BonosController extends Controller
{
	public function index()
    {
        return view('activo.index')
            ->withTitulo('Total de Bonos con stock')
            ->withActivos(Bono::conStock());
    }
}