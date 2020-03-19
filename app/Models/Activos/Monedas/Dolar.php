<?php

namespace App\Models\Activos\Monedas;

use Illuminate\Database\Eloquent\Model;

class Dolar extends Model
{
	public $table = "dolar";

    protected $fillable = ['AC17_en_pesos', 'AC17_en_dolares', 'AC17_mep', 'DICA_en_pesos', 'DICA_en_dolares', 'DICA_mep', 'mep_promedio'];
}