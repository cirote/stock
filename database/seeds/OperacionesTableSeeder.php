<?php

use App\Models\Operaciones\Operacion;
use Illuminate\Database\Seeder;

class OperacionesTableSeeder extends Seeder
{
    public function run()
    {
        Operacion::migrar();
    }
}
