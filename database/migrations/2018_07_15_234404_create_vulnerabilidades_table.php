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
            $table->integer('plugin')->unique()->index(); // tambien id_serpico
            $table->string('nombre')->unique(); 
            $table->integer('criticidad_id'); // 1-'Baja',2-'Media',3-'Alta',4-'Critica'
            $table->string('protocolo')->nullable();
            $table->boolean('exploit')->nullable();
            $table->string('resumen')->nullable();
            $table->string('descripcion');
            $table->string('solucion')->nullable();
            $table->string('referencias')->nullable();
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
        Schema::dropIfExists('vulnerabilidades');
    }
}
