<?php

namespace Cirote\Opciones\Models;

use Illuminate\Support\Collection;
use Tightenco\Parental\HasParent;
use Carbon\Carbon;
use Cirote\Opciones\Config\Config;
use Cirote\Activos\Models\Activo;
use Cirote\Activos\Models\Ask;
use Cirote\Activos\Models\Bid;

class Call extends Activo
{
    use HasParent;

    use Bs;

    public function subyacente()
    {
    	return $this->belongsTo(Activo::class, 'principal_id');
    }

	public function getTasaLibreDeRiesgoAttribute() 
	{
		return Config::TASA_LIBRE_DE_RIESGO;
	}

	public function getEstadoAttribute() 
	{
		if (! $this->valorImplicito)
			return 'OUT';

		if (($this->valorImplicito / $this->subyacente->precioActualPesos) < 0.1)
			return 'AT';

		return 'IN';
	}

  	public function getValorImplicitoAttribute() 
  	{
		return max($this->subyacente->precioActualPesos - $this->strike, 0);
	}

	public function getValorExplicitoAttribute() {
		return max($this->precioActualPesos - $this->valorImplicito, 0);
	}

	public function getTasaAttribute() {
		return $this->valorExplicito / $this->strike;
	}

  	public function getDiasAttribute() 
  	{
		return Carbon::now()->diffInDays($this->vencimiento);
	}

	public function getLoteAttribute() 
	{
		if ($this instanceof Bono)
			return 5000;

		return 100;
	}

	private $precio_teorico;

	public function getPrecioTeoricoAttribute() 
	{
		if (!$this->precio_teorico)
		{
			$this->precio_teorico = $this->getPrecioBS(
				$this->subyacente->precioActualPesos, 
				$this->strike, 
				Config::TASA_LIBRE_DE_RIESGO, 
				Config::VOLATILIDAD_HISTORICA, 
				$this->dias / 365
			);			
		}

		return $this->precio_teorico;
	}

	public function getPrecioBS($s0, $x, $r, $d, $t) 
	{
		$d1 = $this->distribucionNormal($this->d1($s0, $x, $r, $d, $t));

		$d2 = $this->distribucionNormal($this->d2($s0, $x, $r, $d, $t));

		$xt = $x * exp(-$r * $t);

		return ($s0 * $d1) - ($xt * $d2);
	}

	private function volatilidadImplicita($prima) 
	{
		return $this->volatilidad(
			$this->getPrecioSubyacente(), 
			$this->getStrike(), 
			$this->_tasaLibreDeRiesgo, 
			$prima, 
			$this->getDiasAlVencimiento() / 365
		) * 100;
	}
}
