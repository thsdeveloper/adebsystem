<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutorizacaoVisitatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitantes', function (Blueprint $table) {
            $table->boolean('autoriza_envio')->nullable()->comment('Autorização de envio de mensagens')->default(false);
            $table->boolean('autoriza_apresentacao')->comment('Autorização de Apresentação em Público')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visitantes', function (Blueprint $table) {
            $table->dropColumn('autoriza_envio');
            $table->dropColumn('autoriza_apresentacao');
        });
    }
}
