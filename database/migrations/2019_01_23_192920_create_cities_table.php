<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->char('code', 150);
            $table->string('name', 200);
            $table->char('uf', 2);
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->integer('cidade_naturalidade_id')->nullable()->comment('UF de Naturalidade do Obreiro');
            $table->foreign('cidade_naturalidade_id')->references('id')->on('cities');
            $table->integer('uf_naturalidade_id')->nullable()->comment('UF de Naturalidade do Obreiro');
            $table->foreign('uf_naturalidade_id')->references('id')->on('states');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');

//        Schema::table('user_details', function (Blueprint $table) {
//            $table->dropColumn('cidade_naturalidade_id');
//        });

    }
}
