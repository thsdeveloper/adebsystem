<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('Nome do departamento');
            $table->integer('leader_one_id')->comment('Líder 1 do departamento');
            $table->integer('leader_two_id')->comment('Líder 2 do departamento');
            $table->integer('leader_three_id')->nullable()->comment('Líder 3 do departamento');
            $table->text('description')->comment('Descrição do departamento');

            $table->foreign('leader_one_id')->references('id')->on('users');
            $table->foreign('leader_two_id')->references('id')->on('users');
            $table->foreign('leader_three_id')->references('id')->on('users');

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
        Schema::dropIfExists('departments');
    }
}
