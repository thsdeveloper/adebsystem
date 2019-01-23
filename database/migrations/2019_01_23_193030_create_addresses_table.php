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
            $table->string('address')->comment('Endereço do usuário');
            $table->integer('region_id')->comment('Id da região do usuário');
            $table->integer('state_id')->comment('Id do estado do endereço do usuário');
            $table->integer('city_id')->comment('Id da cidade do usuário');
            $table->integer('neighborhood_id')->comment('Id do bairro do usuário');
            $table->string('complement', 200)->nullable()->comment('Complemento do endereço');

            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods');

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
