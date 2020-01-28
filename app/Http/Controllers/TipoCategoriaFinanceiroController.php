<?php

namespace App\Http\Controllers;

use App\Models\TipoDespesaFinanceiro;
use App\Models\TipoReceitaFinanceiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TipoCategoriaFinanceiroController extends Controller
{
    public function inserir(Request $request)
    {
        try {
            //Se for do tipo receita
            //0 = Despesa | 1 = Receita
            switch ($request->tipo) {
                case 0:
                    $tipoDespesa = new TipoDespesaFinanceiro;
                    $tipoDespesa->nome = $request->nome;
                    $tipoDespesa->user_id = Auth::user()->id;
                    $tipoDespesa->save();

                    return response()->json([
                        'status' => true,
                        'msg' => 'Tipo de receita inserida com sucesso!',
                        'categoria' => $tipoDespesa
                    ]);
                    break;
                case 1:

                    $tipoReceita = new TipoReceitaFinanceiro;
                    $tipoReceita->nome = $request->nome;
                    $tipoReceita->user_id = Auth::user()->id;
                    $tipoReceita->save();

                    return response()->json([
                        'status' => true,
                        'msg' => 'Tipo de receita inserida com sucesso!',
                        'categoria' => $tipoReceita
                    ]);

                    break;
                default:
                    return response()->json([]);
                    break;
            }

        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'msg' => 'Error ao cadastrar um tipo de categoria financeira',
                'errors' => $exception->errors(),
            ], 422);
        }

    }

    public function listar(TipoReceitaFinanceiro $tipoReceitaFinanceiro, TipoDespesaFinanceiro $tipoDespesaFinanceiro, Request $request)
    {
        try {
            //0 = Despesa | 1 = Receita
            switch ($request->tipo) {
                case 0:
                    return response()->json($tipoDespesaFinanceiro::orderBy('nome', 'ASC')->get());
                    break;
                case 1:
                    return response()->json($tipoReceitaFinanceiro::orderBy('nome', 'ASC')->get());
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

    public function editar(Request $request)
    {
        try {
            //0 = Despesa | 1 = Receita
            switch ($request->tipo) {
                case 0:
                    $tipoDespesaFinanceiro = TipoDespesaFinanceiro::find($request->id);
                    $tipoDespesaFinanceiro->nome = $request->nome;
                    $tipoDespesaFinanceiro->user_id = Auth::user()->id;

                    if($tipoDespesaFinanceiro->save()){
                        return response()->json([
                            'status' => true,
                            'msg' => 'Tipo de despesa atualizada com sucesso!',
                            'tipoDespesa' => $tipoDespesaFinanceiro
                        ]);
                    }
                    break;
                case 1:
                    $tipoReceitaFinanceiro = TipoReceitaFinanceiro::find($request->id);
                    $tipoReceitaFinanceiro->nome = $request->nome;
                    $tipoReceitaFinanceiro->user_id = Auth::user()->id;

                    if ($tipoReceitaFinanceiro->save()) {
                        return response()->json([
                            'status' => true,
                            'msg' => 'Tipo de receita atualizada com sucesso!',
                            'tipoReceita' => $tipoReceitaFinanceiro
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
                'msg' => 'Error ao atualizar um tipo de receita financeira',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

}
