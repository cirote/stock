<?php

namespace Cirote\Opciones\Actions;

use Illuminate\Database\Eloquent\Collection;

class BorrarOpcionesInexistentesAction
{
    public function execute(Collection $inexistentes): void
    {
    	$inexistentes->each->delete();
    }
}
