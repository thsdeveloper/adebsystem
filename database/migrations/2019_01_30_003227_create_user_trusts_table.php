<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTrustsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_trusts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('trust_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('trust_id')->references('id')->on('trusts');
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
        Schema::dropIfExists('user_trusts');
    }
}
