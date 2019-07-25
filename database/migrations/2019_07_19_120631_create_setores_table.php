<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setores', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('pr_cord_setor_user_id');
            $table->foreign('pr_cord_setor_user_id')->references('id')->on('users');

//            $table->integer('sede_setor_igreja_id');
//            $table->foreign('sede_setor_igreja_id')->references('id')->on('igrejas');

            $table->integer('codigo_setor');
            $table->string('nome_setor');

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
        Schema::dropIfExists('setores');
    }
}
