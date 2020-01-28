<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceitaFinanceiroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receita_financeiro', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tipo_receita_financeiro_id');
            $table->foreign('tipo_receita_financeiro_id')->references('id')->on('tipo_receita_financeiro');

            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('conta_id');
            $table->foreign('conta_id')->references('id')->on('conta_financeiro');

            $table->string('descricao', 200);
            $table->decimal('valor', 12, 2);
            $table->dateTime('data_pagamento');
            $table->boolean('situacao')->default(false);
            $table->text('observacao')->nullable();

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
        Schema::dropIfExists('receita_financeiro');
    }
}
