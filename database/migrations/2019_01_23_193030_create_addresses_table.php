<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            //Informações de endereço
            $table->char('cep', 8)->nullable()->comment('CEP para localização do endereço do usuário');
            $table->integer('state_id')->comment('Id do estado do endereço do usuário');
            $table->integer('city_id')->comment('Id da cidade do usuário');
            $table->string('number', 6)->nullable()->comment('Número da casa, rua, apartamento etc...');
            $table->string('address')->comment('Endereço do usuário');
            $table->string('neighborhood')->comment('Nome do bairro do usuario');

            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('city_id')->references('id')->on('cities');

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
        Schema::dropIfExists('addresses');
    }
}
