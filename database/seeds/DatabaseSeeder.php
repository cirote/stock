<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(MonedasTableSeeder::class);
        $this->call(CryptoTableSeeder::class);
        $this->call(AccionesTableSeeder::class);
        $this->call(BonosTableSeeder::class);
        $this->call(BolsasTableSeeder::class);
        $this->call(BrokerTableSeeder::class);
        $this->call(HistoricosTableSeeder::class);
        $this->call(OperacionesTableSeeder::class);
    }
}
