<?php

namespace App\Http\Controllers;

use App\Models\DespesaFinanceiro;
use App\Models\ReceitaFinanceiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransacaoFinanceiroController extends Controller
{
    public function inserir(Request $request)
    {
        try {
            DB::beginTransaction();

            $valor = $request->transacao['valor'];
            $formatString = str_replace(',', '', $valor);
            $valorFormat = (float)$formatString;




            //0 = Despesa | 1 = Receita
            switch ($request->tipo) {
                case 0:

                    $despesaFinanceiro = new DespesaFinanceiro();
                    $despesaFinanceiro->tipo_despesa_financeiro_id =  $request->transacao['tipo_categoria_id'];
                    $despesaFinanceiro->user_id = Auth::user()->id;

                    //Todo Resolver como vamos inserir o id da conta;
                    $despesaFinanceiro->conta_id = 1;

                    $despesaFinanceiro->descricao = $request->transacao['descricao'];
                    $despesaFinanceiro->valor = $valorFormat;

                    $despesaFinanceiro->data_pagamento = $request->transacao['data_pagamento'];
                    $despesaFinanceiro->situacao = $request->transacao['situacao'];
                    $despesaFinanceiro->observacao = $request->transacao['observacao'];

                    if ($despesaFinanceiro->save()) {
                        DB::commit();
                        return response()->json([
                            'status' => true,
                            'msg' => 'Despesa inserida com sucesso!',
                            'transacao' => $despesaFinanceiro
                        ]);
                    }
                    break;
                case 1:
                    $receitaFinanceiro = new ReceitaFinanceiro();
                    $receitaFinanceiro->tipo_receita_financeiro_id =  $request->transacao['tipo_categoria_id'];
                    $receitaFinanceiro->user_id = Auth::user()->id;

                    //Todo Resolver como vamos inserir o id da conta;
                    $receitaFinanceiro->conta_id = 1;

                    $receitaFinanceiro->descricao = $request->transacao['descricao'];
                    $receitaFinanceiro->valor = $valorFormat;

                    $receitaFinanceiro->data_pagamento = $request->transacao['data_pagamento'];
                    $receitaFinanceiro->situacao = $request->transacao['situacao'];
                    $receitaFinanceiro->observacao = $request->transacao['observacao'];

                    if ($receitaFinanceiro->save()) {
                        DB::commit();
                        return response()->json([
                            'status' => true,
                            'msg' => 'Receita inserida com sucesso!',
                            'transacao' => $receitaFinanceiro
                        ]);
                    }
                    break;
                default:
                    return response()->json([]);
                    break;
            }
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'msg' => 'Error ao cadastrar um tipo de receita financeira',
                'errors' => $exception->errors(),
            ], 422);
        }

    }
}
