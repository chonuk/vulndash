<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->integer('id');
            $table->string('texto');
            $table->string('color');
        });

        DB::table('estados')->insert(
            array(
                ['id' => '4','texto' => 'Abierta','color' => 'danger'],
                ['id' => '3','texto' => 'En Tratamiento','color' => 'warning'],
                ['id' => '2','texto' => 'En Verificacion','color' => 'success'],
                ['id' => '1','texto' => 'Cerrada','color' => 'default'],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estados');
    }
}