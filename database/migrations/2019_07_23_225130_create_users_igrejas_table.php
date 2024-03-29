<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersIgrejasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_igrejas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('igreja_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('igreja_id')->references('id')->on('igrejas');
            $table->timestamps();
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->integer('igreja_id')->nullable()->comment('Igreja do membro');
            $table->foreign('igreja_id')->references('id')->on('igrejas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_igrejas');
        Schema::dropIfExists('user_details');
    }
}
