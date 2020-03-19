<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use App\Models\Activos\Accion;
use App\Models\Activos\Moneda;

class AccionesController extends Controller
{
	public function index()
    {
        return view('activo.index')
            ->withTitulo('Total de Acciones con stock')
            ->withActivos(Accion::conStock());
    }
}