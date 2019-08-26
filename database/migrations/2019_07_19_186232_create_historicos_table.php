<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('activo_id')->unsigned()->refers('id')->on('activos');
            $table->integer('moneda_id')->unsigned()->refers('id')->on('activos');
            $table->date('fecha');
            $table->double('apertura');
            $table->double('maximo');
            $table->double('minimo');
            $table->double('cierre');
            $table->double('volumen');
            $table->double('interes_abierto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historicos');
    }
}
