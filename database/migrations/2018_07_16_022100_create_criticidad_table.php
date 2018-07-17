<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriticidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criticidades', function (Blueprint $table) {
            $table->integer('id');
            $table->string('texto');
            $table->string('color');
        });

        DB::table('criticidades')->insert(
            array(
                ['id' => '1','texto' => 'Baja','color' => 'default'],
                ['id' => '2','texto' => 'Media','color' => 'primary'],
                ['id' => '3','texto' => 'Alta','color' => 'warning'],
                ['id' => '4','texto' => 'Crítica','color' => 'danger'],
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
        Schema::dropIfExists('criticidades');
    }
}
