<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVulnsTable extends Migration
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
            $table->string('titulo', 100); 
            $table->integer('criticidad_id'); // 1-'Critica',2-'Alta',3-'Media',4-'Baja'
            $table->string('descripcion');
            $table->string('remediacion')->nullable();
            $table->string('referencias')->nullable();
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
        Schema::dropIfExists('vulnerabilidades');
    }
}
