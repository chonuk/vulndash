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
        Schema::create('vulnsserpico', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 100)->unique(); 
            $table->integer('criticidad_id'); // 1-'Baja',2-'Media',3-'Alta',4-'Critica'
            $table->string('descripcion');
            $table->string('remediacion')->nullable();
            $table->string('referencias')->nullable();
            $table->integer('id_serpico')->nullable();
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
        Schema::dropIfExists('vulnsserpico');
    }
}
