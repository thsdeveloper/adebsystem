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
        Schema::create('tipo_cadastros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
        });

        Schema::create('cargos_ministeriais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
        });

        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            //Tabelas de relacionamentos
            $table->integer('user_id');
            $table->integer('marital_status_id')->nullable()->comment('Estado civil do usuário');
            $table->string('nome_conjuge')->nullable()->comment('Nome do Conjuge');
            $table->string('nome_pai')->nullable()->comment('Nome do Pai');
            $table->string('nome_mae')->nullable()->comment('Nome da Mâe');
            $table->dateTime('data_batismo')->nullable()->comment('Data do batismo');
            $table->text('observacao')->nullable()->comment('Observações sobre o membro');
            $table->integer('schooling_id')->comment('Id da Escolaridade do usuário');
            $table->integer('gender_id')->comment('Id do Sexo do Usuário');
            $table->integer('forma_ingresso_id')->nullable()->comment('Forma de ingresso na igreja');
            $table->integer('tipo_cadastro_id')->comment('Tipo de Cadastro');
            $table->integer('cargo_ministerial_id')->nullable()->comment('Cargo Ministerial');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('marital_status_id')->references('id')->on('marital_status');
            $table->foreign('schooling_id')->references('id')->on('schoolings');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('tipo_cadastro_id')->references('id')->on('tipo_cadastros');
            $table->foreign('cargo_ministerial_id')->references('id')->on('cargos_ministeriais');

            $table->dateTime('data_nascimento')->comment('Data de nascimento do usuário');
            $table->string('cpf')->comment('CPF do Usuário');
            $table->string('rg')->comment('Registro Geral do Usuário - RG');
            $table->integer('profession_id')->comment('Profissão do usuário');
            $table->foreign('profession_id')->references('id')->on('professions');

            $table->char('phone')->nullable()->comment('Telefone de contato do usuário');
            $table->dateTime('data_conversao')->nullable()->comment('Data da conversão do usuário');

            $table->dateTime('data_consagracao')->nullable()->comment('Data da consagração do membro');
            $table->integer('curso_teologico_id')->nullable()->comment('Curso teológico id');
            $table->string('convencao_igreja')->nullable()->comment('Convenção');
            $table->string('cod_comadebg')->nullable()->comment('Código da COMADEBG');
            $table->string('cod_cgadb')->nullable()->comment('Código da CGADB');
            $table->integer('situacao_ministerio_id')->nullable()->comment('Situação no Ministério');
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
        Schema::dropIfExists('tipo_cadastros');
        Schema::dropIfExists('cargos_ministeriais');
    }
}
