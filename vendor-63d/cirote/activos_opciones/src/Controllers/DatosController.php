<?php

namespace Cirote\Opciones\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cirote\Opciones\Models\Inexistente;
use Cirote\Opciones\Actions\CalcularTickerCompletoOpcionAction;

use Cirote\Activos\Models\Activo;
use Cirote\Activos\Models\Accion;
use Cirote\Activos\Models\Precio;
use Cirote\Activos\Models\Ticker;

use App\Models\Activos\Monedas\Dolar;

class DatosController extends Controller
{
	public function store_opciones(Request $request, CalcularTickerCompletoOpcionAction $calcularTicker)
	{
		$dolar = Dolar::orderByDesc('updated_at')->first();

		foreach($request->input('Datos') as $dato)
		{
			$tickerOriginal = $dato['ticker'];

			$tickerCompleto = $calcularTicker->execute($tickerOriginal);

			if ($ticker = Ticker::byName($tickerCompleto))
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
				else 
			{
				$this->informarTickerInexistente($dato);
			}
		}

	    return $this->todoOk();
	}

	private function putPrecio($ticker, $pesos, $dolares, $dato): Precio
	{
		if ($precio = $ticker->activo->precio) {

			$precio->bid_precio	= $this->limpiar($dato['compra_precio']);
			$precio->bid_cantidad = $this->limpiar($dato['compra_cantidad']); 
			$precio->ask_precio	= $this->limpiar($dato['venta_precio']);
			$precio->ask_cantidad = $this->limpiar($dato['venta_cantidad']); 
			$precio->precio_pesos = $pesos;
			$precio->precio_dolares = $dolares;

			$precio->save();
		}

		return $ticker->activo->precio()->create([
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

	private function informarTickerInexistente($atributos)
	{
		$tickerOpcion = $atributos['ticker'];

		$tickerSubyacente = substr($tickerOpcion, 0, 3);

		$subyacente = Activo::byTicker($tickerSubyacente);

		Inexistente::firstOrCreate([
			'ticker' 	    => $tickerOpcion,
			'subyacente_id' => $subyacente->id ?? null
		]);
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
