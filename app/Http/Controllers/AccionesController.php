<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use Cirote\Activos\Models\Accion;
use Cirote\Activos\Models\Moneda;

class AccionesController extends Controller
{
	public function index()
    {
        return view('activo.index')
            ->withTitulo('Total de Acciones con stock')
            ->withActivos(Accion::conStock());
    }
}