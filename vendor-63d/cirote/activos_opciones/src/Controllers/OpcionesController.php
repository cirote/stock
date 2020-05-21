<?php

namespace Cirote\Opciones\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cirote\Opciones\Config\Config;
use Cirote\Opciones\Models\Call;

use App\Models\Activos\Activo;

class OpcionesController extends Controller
{
	public function index()
    {
        return view('opciones::opciones.index')
            ->withActivos(Call::with('precio', 'ticker', 'subyacente')
                ->has('precio')
                ->get()
                ->paginate(Config::ELEMENTOS_POR_PAGINA)
            );
    }

	public function activos(Activo $activo)
    {
        return view('opciones::inexistentes.mostrar')
        	->withActivo($activo)
        	->withOpciones(Inexistente::where('subyacente_id', $activo->id)
                ->get()
                ->each
                ->setRelation('subyacente', $activo)
                ->sortBy('sortString')
                ->paginate(Config::ELEMENTOS_POR_PAGINA)
            );
    }
}
