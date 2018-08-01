<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVulnerabilidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('vulnerabilidades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activos_id')->unsigned()->index();
            $table->integer('vulnsinfra_id')->unsigned()->index();
            $table->integer('puerto')->unsigned()->index();
            $table->date('primer_deteccion');
            $table->date('ultima_deteccion');
            $table->integer('estados_id')->index();
            $table->timestamps();

            $table->foreign('activos_id')->references('id')->on('activos')->onDelete('cascade');
            $table->foreign('vulnsinfra_id')->references('id')->on('vulnsinfra')->onDelete('cascade');

            $table->unique(['activos_id', 'vulnsinfra_id', 'puerto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vulnerabilidades');
    }
}
