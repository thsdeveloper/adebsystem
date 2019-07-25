<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSedeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sede', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('presidente_user_id');
            $table->foreign('presidente_user_id')->references('id')->on('users');

            $table->integer('primeiro_vice_user_id');
            $table->foreign('primeiro_vice_user_id')->references('id')->on('users');

            $table->integer('segundo_vice_user_id');
            $table->foreign('segundo_vice_user_id')->references('id')->on('users');

            $table->integer('terceiro_vice_user_id');
            $table->foreign('terceiro_vice_user_id')->references('id')->on('users');

            $table->integer('quarto_vice_user_id');
            $table->foreign('quarto_vice_user_id')->references('id')->on('users');

            $table->integer('igreja_id');
            $table->foreign('igreja_id')->references('id')->on('igrejas');
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
        Schema::dropIfExists('sede');
    }
}
