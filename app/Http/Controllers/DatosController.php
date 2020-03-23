<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activos\Activo;
use App\Models\Activos\Accion;
use App\Models\Activos\Precio;
use App\Models\Activos\Ticker;
use App\Models\Activos\Monedas\Dolar;

class DatosController extends Controller
{
	public function store_dolar(Request $request)
	{
		foreach($request->input('Datos') as $dato)
		{
			$ticker = $dato['ticker'];

			switch ($ticker) 
			{
				case 'AC17':

					$ac17 = $this->limpiar($dato['ultimo_precio']);

					break;

				case 'AC17D':

					$ac17d = $this->limpiar($dato['ultimo_precio']);

					break;

				case 'DICA':

					$dica = $this->limpiar($dato['ultimo_precio']);

					break;

				case 'DICAD':

					$dicad = $this->limpiar($dato['ultimo_precio']);

					break;

				default:

					break;
			}
		}

		$mep_ac17 = $ac17d ? $ac17 / $ac17d : 0;

		$mep_dica = $dicad ? $dica / $dicad : 0;

		$mep = ($mep_ac17 + $mep_dica) / 2;

		Dolar::create([
			'AC17_en_pesos'		=> $ac17, 
			'AC17_en_dolares'	=> $ac17d, 
			'AC17_mep'			=> $mep_ac17, 
			'DICA_en_pesos'		=> $dica, 
			'DICA_en_dolares'	=> $dicad, 
			'DICA_mep'			=> $mep_dica, 
			'mep_promedio'		=> $mep
		]);

	    return $this->todoOk();
	}

	public function store_acciones(Request $request)
	{
		$dolar = Dolar::orderByDesc('updated_at')->first();

		foreach($request->input('Datos') as $dato)
		{
			$ticker = $this->getTickerAccion($dato);

			$precio_pesos = $this->limpiar($dato['ultimo_precio']);

			$precio_dolares = $precio_pesos / $dolar->mep_promedio;

			$this->putPrecio(
				$ticker, 
				$precio_pesos, 
				$precio_dolares, 
				$dato
			);
		}

	    return $this->todoOk();
	}

	private function getTickerAccion($dato): Ticker
	{
		if ($ticker = Ticker::byName($dato['ticker']))
		{
			return $ticker;				
		}

        $activo = Accion::create([
            'denominacion' => $dato['nombre'],
            'clase'  => 'Acciones ordinarias'
        ]);

        $activo->agregarTicker($dato['ticker']);

        return Ticker::byName($dato['ticker']);			
	}

	private function putPrecio($ticker, $pesos, $dolares, $dato): Precio
	{
		return $ticker->activo->precio()->updateOrCreate([
			'ticker_id'		 => $ticker->id, 
			'mercado_id'	 => 1, 
			'moneda_id'		 => 2, 
			'bid_precio'	 => $this->limpiar($dato['compra_precio']), 
			'bid_cantidad'	 => $this->limpiar($dato['compra_cantidad']), 
			'ask_precio'	 => $this->limpiar($dato['venta_precio']), 
			'ask_cantidad'	 => $this->limpiar($dato['venta_cantidad']), 
			'precio_pesos'	 => $pesos, 
			'precio_dolares' => $dolares
		]);
	}

	public function store_bonos(Request $request)
	{
		$dolar = Dolar::orderByDesc('updated_at')->first();

		foreach($request->input('Datos') as $dato)
		{
			if ($ticker = Ticker::byName($dato['ticker']))
			{
				if (strlen($dato['ticker']) > 4)
				{
					$precio_pesos = 0;

					$precio_dolares = $this->limpiar($dato['ultimo_precio']) / 100;			
				}

				else
				{
					$precio_pesos = $this->limpiar($dato['ultimo_precio']) / 100;

					$precio_dolares = $precio_pesos / $dolar->mep_promedio;				
				}
			
				$this->putPrecio(
					$ticker, 
					$precio_pesos, 
					$precio_dolares, 
					$dato
				);
			}
		}

	    return $this->todoOk();
	}

	public function store_opciones(Request $request)
	{
		$dolar = Dolar::orderByDesc('updated_at')->first();

		foreach($request->input('Datos') as $dato)
		{
			if ($ticker = Ticker::byName($dato['ticker']))
			{
				$precio_pesos = $this->limpiar($dato['ultimo_precio']);

				$precio_dolares = $precio_pesos / $dolar->mep_promedio;

				$this->putPrecio(
					$ticker, 
					$precio_pesos, 
					$precio_dolares, 
					$dato
				);
			}
		}

	    return $this->todoOk();
	}

	private function todoOk()
	{
	    return response()->json([
	    	'success'=>'Data is successfully added',
	    ]);
	}

	private function limpiar($texto)
	{
		$texto = str_replace('.', '', $texto);

		$texto = str_replace(',', '.', $texto);

		return (double) $texto;
	}
}
