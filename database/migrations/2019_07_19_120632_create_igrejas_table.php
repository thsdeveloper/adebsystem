<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIgrejasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('igrejas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('pr_user_id')->nullable();
            $table->foreign('pr_user_id')->references('id')->on('users');
            $table->integer('co_pr_user_id')->nullable();
            $table->foreign('co_pr_user_id')->references('id')->on('users');
            $table->integer('tesoureiro_user_id')->nullable();
            $table->foreign('tesoureiro_user_id')->references('id')->on('users');
            $table->integer('endereco_id')->nullable();
            $table->foreign('endereco_id')->references('id')->on('addresses');
            $table->integer('setor_id');
            $table->foreign('setor_id')->references('id')->on('setores');
            $table->string('nome_igreja');
            $table->softDeletes();
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
        Schema::dropIfExists('igrejas');
    }
}
