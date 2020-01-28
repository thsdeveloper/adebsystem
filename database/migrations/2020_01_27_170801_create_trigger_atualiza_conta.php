<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerAtualizaConta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER atualiza_conta_despesa
            AFTER INSERT
            ON despesa_financeiro
            FOR EACH ROW
        EXECUTE PROCEDURE atualiza_conta();

        CREATE TRIGGER atualiza_conta_receita
            AFTER INSERT
            ON receita_financeiro
            FOR EACH ROW
        EXECUTE PROCEDURE atualiza_conta();
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER atualiza_conta_receita ON receita_financeiro');
        DB::unprepared('DROP TRIGGER atualiza_conta_despesa ON despesa_financeiro');
    }
}
