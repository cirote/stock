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

        $a = $this->tiempo();
        $exchange->fetch_exchange_info();
        $this->tiempo($a, 'Lectura de datos del webservice');

        $a = $this->tiempo();
        $exchange->fetch_mercados();
        $this->tiempo($a, 'Conversion de los datos');

        $ar = ['BTC', 'LTC', 'USDT', 'OKB', 'XRP', 'EOS'];
        $br = ['ETH', 'BTC', 'LTC', 'USDT', 'BCH', 'OKB', 'XRP', 'EOS'];

        foreach ($ar as $entre) {
            $a = $this->tiempo();
            $y = 'ETH';
            $exchange->arbitrar($entre, $y);
            $this->tiempo($a, "Opciones de arbitraje de $entre");
        }


        $this->info('');

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
