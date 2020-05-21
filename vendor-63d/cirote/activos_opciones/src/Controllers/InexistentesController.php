<?php

namespace Cirote\Opciones\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cirote\Opciones\Config\Config;
use Cirote\Opciones\Models\Inexistente;
use Cirote\Opciones\Actions\AgregarOpcionesInexistentesAction;
use Cirote\Opciones\Actions\BorrarOpcionesInexistentesAction;
use Cirote\Activos\Models\Activo;

class InexistentesController extends Controller
{
	public function index()
    {
        return view('opciones::inexistentes.index')
        	->withActivos(Inexistente::select('subyacente_id')
                ->distinct()
                ->get()
                ->load('subyacente')
                ->paginate(Config::ELEMENTOS_POR_PAGINA)
            );
    }

	public function mostrar(Activo $activo)
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

    public function agregar(Activo $activo, AgregarOpcionesInexistentesAction $agregar)
    {
        $agregar->borrarDespuesDeAgregar()
            ->execute(Inexistente::where('subyacente_id', $activo->id)
                ->get()
                ->each
                ->setRelation('subyacente', $activo)
            );

        return redirect()->route('inexistentes.index');
    }

    public function borrar(Activo $activo, BorrarOpcionesInexistentesAction $borrar)
    {
        $borrar->execute(Inexistente::where('subyacente_id', $activo->id)
            ->get()
        );

        return redirect()->route('inexistentes.index');
    }
}
