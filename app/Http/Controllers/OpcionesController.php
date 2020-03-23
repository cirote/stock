<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use App\Models\Activos\Activo;
use App\Models\Activos\Call;
use App\Models\Activos\Moneda;

class OpcionesController extends Controller
{
	public function index()
    {
        return view('activo.opciones')
            ->withTitulo('Total de opciones')
            ->withActivos(Call::with('operaciones', 'precio', 'ticker', 'subyacente')->has('precio')->get());
    }

	public function activo(Activo $activo)
    {
        $activo->load('precio');

        return view('activo.opciones')
            ->withTitulo("Opciones de {$activo->denominacion}: ($ {$activo->precioActualPesos})")
            ->withActivos($activo->calls()->with('operaciones', 'precio', 'ticker', 'subyacente')->get());
    }
}