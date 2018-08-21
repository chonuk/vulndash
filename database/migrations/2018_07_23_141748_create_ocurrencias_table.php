<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOcurrenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('ocurrencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activos_id')->unsigned()->index();
            $table->integer('vulnerabilidades_id')->unsigned()->index();
            $table->integer('puerto')->unsigned()->index();
            $table->date('primer_deteccion')->nullable();
            $table->date('ultima_deteccion')->nullable();
            $table->integer('estados_id')->index();
            $table->timestamps();

            $table->foreign('activos_id')->references('id')->on('activos')->onDelete('cascade');
            $table->foreign('vulnerabilidades_id')->references('id')->on('vulnerabilidades')->onDelete('cascade');

            $table->unique(['activos_id', 'vulnerabilidades_id', 'puerto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ocurrencias');
    }
}
