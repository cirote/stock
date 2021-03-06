<?php

namespace App\Models\Activos;

use Illuminate\Database\Eloquent\Model;
use Cirote\Activos\Models\Activo;
use Cirote\Activos\Config\Config;

class Bolsa extends Model
{
    protected $table = Config::PREFIJO . Config::BOLSAS;

    static public function byName($name)
    {
        return static::where('nombre', $name)->first();
    }

    /*
     * Funciones con mercados
     */
    public function mercados()
    {
        return $this->hasMany(Mercado::class);
    }

    public function agregarMercado($nombre, $moneda, ...$activos)
    {
        $mercado = $this->mercados()->create([
            'nombre' => $nombre,
            'moneda_id' => Activo::byTicker($moneda)->id
        ]);

        foreach ($activos as $ticker)
        {
            $activo = Activo::byTicker($ticker);

            $mercado->activos()->save($activo);
        }

        return $this;
    }
}
