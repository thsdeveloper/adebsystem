<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespesaFinanceiroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despesa_financeiro', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tipo_despesa_financeiro_id');
            $table->foreign('tipo_despesa_financeiro_id')->references('id')->on('tipo_despesa_financeiro');

            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('conta_id');
            $table->foreign('conta_id')->references('id')->on('conta_financeiro');

            $table->string('descricao', 200);
            $table->double('valor', 8, 2);
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
        Schema::dropIfExists('despesa_financeiro');
    }
}
