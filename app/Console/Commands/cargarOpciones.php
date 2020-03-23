<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Activos\Activo;
use App\Models\Activos\Accion;
use App\Models\Activos\Bono;
use App\Models\Activos\Call;

class cargarOpciones extends Command
{
	const MES = 'JU';

    protected $signature = 'populate:opciones';

    protected $description = 'Actualiza la informacion de las opciones de activos elegidos';

    public function handle()
    {
    	$this->cargarActivos();
    }

    private function cargarActivos(): void
    {
    	foreach ($this->activos() as $activo) {
    		$this->cargarOpciones($activo);
    	}
    }

    private function cargarOpciones($variables): void
    {
    	list($tickerPrincipal, $raizNombre, $minimo, $maximo, $step) = $variables;

    	$activo = Activo::byTicker($tickerPrincipal);

        $this->borrarOpciones($activo, static::MES);

    	for ($f = $minimo; $f <= $maximo; $f += $step) {
            $this->crearOpcion(
                $activo,
                $this->makeTickerCall($raizNombre, $f, static::MES),
                $f,
                $this->vencimiento($activo, static::MES)
            );
    	}
    }

    private function borrarOpciones(Activo $activo, $mes)
    {
        foreach ($activo->calls as $opcion)
        {
            $opcion->ticker()->delete();

            $opcion->precio()->delete();

            $opcion->delete();
        }
    }

    private function crearOpcion(Activo $activo, string $ticker, Float $strike, Carbon $fecha)
    {
        $this->crearCall($activo, $ticker, $strike, $fecha)
            ->agregarTicker($ticker);
    }

    private function crearCall(Activo $activo, string $ticker, Float $strike, Carbon $fecha)
    {
        return $activo->calls()->create([
            'denominacion'  => $activo->denominacion,
            'clase'         => 'Opcion',
            'strike'        => $strike,
            'vencimiento'   => $fecha
        ]);
    }

    private function makeTickerCall($raiz, $valor, $mes): string
    {
        if ($valor < 100)
        	return "{$raiz}C{$valor}.0{$mes}";

        return "{$raiz}C{$valor}.{$mes}";
    }

    private function vencimiento(Activo $activo, $mes): Carbon
    {
        if ($activo instanceof Accion)
        {
            switch ($mes) {
                case 'JU':
                    return Carbon::create(2020, 6, 19, 0, 0, 0, 0);
                    break;
                
                default:
                    break;
            }
        }
    }

    private function activos(): array
    {
    	return [
    		['YPF', 'YPF', 220.0, 420.0, 20],
            ['GGAL', 'GFG', 30.0, 90.0, 3],
    	];
    }
}
