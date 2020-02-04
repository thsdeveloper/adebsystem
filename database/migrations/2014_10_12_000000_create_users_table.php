<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('situacoes_membros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->comment('Nome da Situação');
            $table->timestamps();
        });

        //Tabela do usuário
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('matricula')->unique()->comment('Número da Matrícula do user');
            $table->integer('status_id');
            $table->foreign('status_id')->references('id')->on('situacoes_membros');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('situacoes_membros');

    }
}
