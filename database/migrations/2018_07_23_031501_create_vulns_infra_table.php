<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVulnsInfraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('vulnsinfra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plugin')->unique()->index();
            $table->string('nombre');
            $table->integer('criticidad_id');
            $table->string('protocolo');
            $table->boolean('exploit');
            $table->string('resumen');
            $table->longtext('descripcion');
            $table->longtext('solucion');
            $table->text('referencias')->nullable();
            $table->string('cve')->nullable();
            $table->datetime('salida_parche')->nullable();
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
        Schema::dropIfExists('vulnsinfra');
    }
}
