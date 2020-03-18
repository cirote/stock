<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activos\Activo;
use App\Models\Activos\Accion;

class DatosController extends Controller
{
	public function store(Request $request)
	{
		foreach($request->input('Datos') as $dato)
		{
			$ticker = $dato[0];

			$activo = Activo::byTicker($ticker);

			if (! $activo)
			{
				$nombre = $dato[1];

				if ($nombre)
				{
			        Accion::create([
			            'denominacion' => $nombre,
			            'clase'  => 'Acciones ordinarias'
			        ])
			        ->agregarTicker($ticker);				
				}
			}
		}

	    return response()->json([
	    	'success'=>'Data is successfully added',
	    	//'datos' => $request->toJson()
	    ]);
	}
}
