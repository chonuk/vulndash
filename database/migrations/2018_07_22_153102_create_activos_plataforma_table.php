<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivosPlataformaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activo_plataforma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activo_id')->unsigned()->index();
            $table->foreign('activo_id')->references('id')->on('activos')->onDelete('cascade');

            $table->integer('plataforma_id')->unsigned()->index();
            $table->foreign('plataforma_id')->references('id')->on('plataformas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activo_plataforma');
    }
}
