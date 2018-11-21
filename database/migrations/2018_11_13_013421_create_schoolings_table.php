<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schoolings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comment('Nome de Escolaridade');
            $table->boolean('status')->comment('Se está ativo. 0 = Não, 1 = Sim');
            $table->text('description')->comment('Uma descrição para a escolaridade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schoolings');
    }
}
