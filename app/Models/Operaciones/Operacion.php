<?php

namespace App\Models\Operaciones;

use App\Models\Activos\Activo;
use App\Models\Broker;
use Error;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tightenco\Parental\HasChildren;

class Operacion extends Model
{
    use HasChildren;

    protected $table = 'operaciones';

    static public function migrar()
    {
        static::migrarPPI();
    }

    static public function migrarPPI()
    {
        static::migrarArchivoPPI('Movimientos 01.xlsx');
        static::migrarArchivoPPI('Movimientos 2019.xlsx');
    }

    static public function migrarArchivoPPI($file)
    {
        $broker = Broker::bySigla('PPI');

        $libro = static::leerLibro($broker->sigla, $file);

        $planillas = $libro->getSheetNames();

        foreach ($planillas as $planilla)
        {
            $datos = $libro->getSheetByName($planilla)->toArray(null, true, true, true);

            foreach ($datos as $dato)
            {
                static::agregarRegistro($dato);
            }
        }
    }

    static public function agregarRegistro($dato)
    {
        $fecha = trim($dato['A']);
        if (! (strlen($fecha) == 10))
            return;

        $fecha = Carbon::createFromFormat("d/m/Y H:i:s", $fecha . ' 00:00:00');

        $descripcion = trim($dato['B']);

        if ($descripcion == 'Ingreso de Fondos')
        {
            Deposito::create([
                'fecha' => $fecha,
                'importe' => tofloat($dato['E'])
            ]);
        };

        if (Str::startsWith($descripcion, 'COMPRA'))
        {
            $partes = explode(' ', $descripcion);

            if (count($partes) == 2)
            {
                $ticker = trim($partes[1]);

                $activo = Activo::byTicker($ticker);

                if ($activo) {
                    Compra::create([
                        'fecha' => $fecha,
                        'activo_id' => $activo ? $activo->id : null,
                        'cantidad' => tofloat($dato['C']),
                        'precio' => tofloat($dato['D']),
                        'importe' => tofloat($dato['E'])
                    ]);
                }
            }
        }
//                Deposito::create([
//                    'fecha' => Carbon::createFromFormat("d/m/Y H:i:s", $fecha . ' 00:00:00'),
//                    'descripcion' => 'Ingreso de fondos',
//                    'cantidad' => 0,
//                    'precio' => 0,
//                    'importe' => tofloat($dato['E'])
//                ]);

    }

    public static function leerLibro($sigla, $file)
    {
        $url = storage_path("app/historico/BCBA/{$sigla}/{$file}");

        if (! file_exists($url))
            throw new error("El archivo [$url] no existe");

        $reader = IOFactory::createReaderForFile($url);
        $reader->setReadDataOnly(true);

        return $reader->load($url);
    }
}

function tofloat($num)
{
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    }

    return floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
    );
}
