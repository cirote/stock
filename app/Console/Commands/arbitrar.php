<?php

namespace App\Console\Commands;

use App\Models\Exchanges\okex;
use Illuminate\Console\Command;

class arbitrar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arbitrar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Arbitraje de monedas en OKEX';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('');
        $this->error('Bienvenido a Arbitrator 2.0');

        $a = $this->tiempo();
        $exchange = Okex::create();
        $this->tiempo($a, 'Creacion del exchange');

        while (true) {

            $ar = ['ETH', 'BTC', 'USDT', 'OKB', 'XRP'];

            $a = $this->tiempo();
            $exchange->fetch_exchange_info();
            $this->tiempo($a, 'Lectura de datos del webservice');

            $a = $this->tiempo();
            $exchange->fetch_mercados();
            $this->tiempo($a, 'Conversion de los datos');

            while (count($ar) > 2) {

                $entre = array_shift($ar);

                foreach ($ar as $y) {
                    $a = $this->tiempo();
                    $exchange->arbitrar($entre, $y);
                    $this->tiempo($a, "Fueron las opciones de arbitraje de $entre");
                }
            }
            $this->info('');
            sleep(15);
        }

        die();
    }

    function tiempo($control = null, $titulo = null)
    {
        //list($useg, $seg) = explode(" ", microtime());

        $a = microtime(true);

        if ($control) {
            $d = ($a - $control);
//            $this->info('');
//            $this->info($titulo);
//            $this->line('Duracion del proceso ' . number_format($d, 6) . ' ');
              return $d;
        }

        return $a;
    }
}
