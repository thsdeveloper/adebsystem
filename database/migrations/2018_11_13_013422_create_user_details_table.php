<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Tabela de detalhes do Usuário
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            //Tabelas de relacionamentos
            $table->integer('user_id');
            $table->integer('marital_status_id')->nullable()->comment('Estado civil do usuário');
            $table->integer('spouse_id')->nullable()->comment('Id do conjuge do usuário se tiver');
            $table->integer('schooling_id')->comment('Id da Escolaridade do usuário');
            $table->integer('gender_id')->comment('Id do Sexo do Usuário');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('marital_status_id')->references('id')->on('marital_status');
            $table->foreign('spouse_id')->references('id')->on('users');
            $table->foreign('schooling_id')->references('id')->on('schoolings');
            $table->foreign('gender_id')->references('id')->on('genders');

            $table->date('date_birth')->comment('Data de nascimento do usuário');
            $table->string('mother_name', 200)->comment('Nome da mãe do usuário');
            $table->string('dad_name', 200)->comment('Nome do pai do usuário');
            $table->string('cpf', 11)->comment('CPF do Usuário');
            $table->string('rg', 50)->comment('Registro Geral do Usuário - RG');
            $table->integer('profession_id')->comment('Profissão do usuário');
            $table->foreign('profession_id')->references('id')->on('professions');

            $table->char('phone', 11)->nullable()->comment('Telefone de contato do usuário');
            $table->date('date_conversion')->nullable()->comment('Data da conversão do usuário');
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
        Schema::dropIfExists('user_details');
    }
}
