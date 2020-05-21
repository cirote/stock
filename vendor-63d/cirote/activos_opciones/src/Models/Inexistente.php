<?php

namespace Cirote\Opciones\Models;

use Illuminate\Database\Eloquent\Model;
use Cirote\Opciones\Config\Config;
use Cirote\Opciones\Actions\CalcularStrikeOpcionAction;
use Cirote\Opciones\Actions\CalcularTickerCompletoOpcionAction;
use Cirote\Opciones\Actions\CalcularVencimientoOpcionAction;
use Cirote\Activos\Models\Activo;
use Cirote\Opciones\Models\Call;
use Cirote\Opciones\Models\Put;

class Inexistente extends Model
{
    protected $table = Config::PREFIJO . Config::INEXISTENTES;

    protected $guarded = [];

    private $calcularVencimientoAction;

    private $calcularStrikeAction;

    private $calcularTickerCompletoAction;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->calcularVencimientoAction = App()->make(CalcularVencimientoOpcionAction::class);

        $this->calcularStrikeAction = App()->make(CalcularStrikeOpcionAction::class);

        $this->calcularTickerCompletoAction = App()->make(CalcularTickerCompletoOpcionAction::class);
    }

    public function subyacente()
    {
    	return $this->belongsTo(Activo::class, 'subyacente_id');
    }

    public function getVencimientoAttribute()
    {
        return $this->calcularVencimientoAction->execute($this->ticker);
    }

    public function getStrikeAttribute()
    {
        return $this->calcularStrikeAction->execute($this->ticker);
    }

    public function getTickerCompletoAttribute()
    {
        return $this->calcularTickerCompletoAction->execute($this->ticker);
    }

    public function getTipoAttribute()
    {
    	return substr($this->ticker, 3, 1) == 'C'
    		? Call::class 
    		: Put::class;
    }

    public function getSortStringAttribute()
    {
    	return (100 + $this->vencimiento->month) . (1000000 + $this->strike) . substr($this->ticker, 3, 1);
    }
}
