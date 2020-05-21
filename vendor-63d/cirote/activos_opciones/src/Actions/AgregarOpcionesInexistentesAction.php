<?php

namespace Cirote\Opciones\Actions;

use Illuminate\Database\Eloquent\Collection;
use Cirote\Opciones\Actions\BorrarOpcionesInexistentesAction;

class AgregarOpcionesInexistentesAction
{
    private $borrar;

    private $deboBorrar = false;

    public function __construct()
    {
        $this->borrar = new BorrarOpcionesInexistentesAction();
    }

    public function execute(Collection $inexistentes): void
    {
    	$inexistentes->each(function ($inexistente) 
    	{
    		$opcion = $inexistente->tipo::firstOrNew([
    			'principal_id'	=> $inexistente->subyacente->id,
	            'denominacion'  => $inexistente->subyacente->denominacion,
	            'clase'         => 'Opcion',
	            'strike'        => $inexistente->strike,
	            'vencimiento'   => $inexistente->vencimiento
	        ]);

            $opcion->save();
            
            $opcion->agregarTicker($inexistente->tickerCompleto);
		});

        if ($this->deboBorrar)
        {
            $this->borrar->execute($inexistentes);
        }
    }

    public function borrarDespuesDeAgregar()
    {
        $this->deboBorrar = true;

        return $this;
    }
}
