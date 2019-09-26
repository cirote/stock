<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperacionsTable extends Migration
{
    public function up()
    {
        Schema::create('operaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('clase')->nullable();
            $table->string('type')->nullable();
            $table->date('fecha');
            $table->bigInteger('activo_id')->refers('id')->on('activos')->nullable();
            $table->string('descripcion')->nullable();
            $table->bigInteger('cantidad')->nullable();
            $table->decimal('precio')->nullable();
            $table->decimal('importe');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('operaciones');
    }
}
