<?php

namespace App\Models\Operaciones;

use Illuminate\Database\Eloquent\Model;
use Tightenco\Parental\HasChildren;
use App\Models\Activos\Activo;

class Operacion extends Model
{
    use HasChildren;

    protected $table = 'operaciones';

    protected $fillable = ['id', 'fecha', 'activo_id', 'broker_id', 'cantidad', 'precio', 'pesos', 'dolares'];

    static public function aportes()
    {
        return static::where('type', Deposito::class);
    }
}
