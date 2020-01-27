<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunctionAtualizaConta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE OR REPLACE FUNCTION atualiza_conta()
            RETURNS trigger AS
        $$

        DECLARE
            saldo      double precision;
            novo_valor double precision;

        BEGIN
            SELECT conta_financeiro.saldo
            INTO STRICT saldo
            FROM conta_financeiro
            WHERE conta_financeiro.id = New.conta_id;

            --caso seja receita
            novo_valor := saldo + New.valor;

            IF (TG_TABLE_NAME = 'despesa_financeiro') THEN
                novo_valor := saldo - New.valor;
            END IF;

            UPDATE public.conta_financeiro SET saldo = novo_valor WHERE id = New.conta_id;

            RETURN NEW;

        END;
        $$
            LANGUAGE plpgsql;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION atualiza_conta() CASCADE');
    }
}
