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

            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('pr_cord_setor_user_id')->nullable();
            $table->foreign('pr_cord_setor_user_id')->references('id')->on('users');

            $table->integer('endereco_id')->nullable();
            $table->foreign('endereco_id')->references('id')->on('addresses');

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
