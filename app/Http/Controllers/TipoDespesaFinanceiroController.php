<?php

namespace App\Http\Controllers;

use App\Models\TipoDespesaFinanceiro;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoDespesaFinanceiroController extends Controller
{
    public function inserir(Request $request)
    {
        try {
            $tipoDespesa = new TipoDespesaFinanceiro;
            $tipoDespesa->nome = $request->nome;
            $tipoDespesa->save();

            return response()->json([
                'status' => true,
                'msg' => 'Tipo de receita inserida com sucesso!',
                'tipoDespesa' => $tipoDespesa
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'msg' => 'Error ao cadastrar um tipo de despesa financeira',
                'errors' => $exception->errors(),
            ], 422);
        }

    }

    public function listar(TipoDespesaFinanceiro $tipoDespesaFinanceiro){
        try {
            return response()->json($tipoDespesaFinanceiro::all());
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'msg' => 'Error ao listar um tipo de despesa financeira',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    public function editar(Request $request){
        try {
            $tipoDespesaFinanceiro = TipoDespesaFinanceiro::find($request->id);
            $tipoDespesaFinanceiro->nome = $request->nome;

            if($tipoDespesaFinanceiro->save()){
                return response()->json([
                    'status' => true,
                    'msg' => 'Tipo de despesa atualizada com sucesso!',
                    'tipoDespesa' => $tipoDespesaFinanceiro
                ]);
            }

        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'msg' => 'Error ao atualizar um tipo de despesa financeira',
                'errors' => $exception->errors(),
            ], 422);
        }
    }
}
