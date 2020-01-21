<?php

namespace App\Http\Controllers;

use App\Models\TipoDespesaFinanceiro;
use App\Models\TipoReceitaFinanceiro;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoReceitaFinanceiroController extends Controller
{
    public function inserir(Request $request)
    {
        try {
            $tipoReceita = new TipoReceitaFinanceiro;
            $tipoReceita->nome = $request->nome;
            $tipoReceita->save();

            return response()->json([
                'status' => true,
                'msg' => 'Tipo de receita inserida com sucesso!',
                'tipoReceita' => $tipoReceita
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'msg' => 'Error ao cadastrar um tipo de receita financeira',
                'errors' => $exception->errors(),
            ], 422);
        }

    }

    public function listar(TipoReceitaFinanceiro $tipoReceitaFinanceiro){
        try {
            return response()->json($tipoReceitaFinanceiro::all());
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'msg' => 'Error ao cadastrar um tipo de receita financeira',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    public function editar(Request $request){
        try {
            $tipoReceitaFinanceiro = TipoReceitaFinanceiro::find($request->id);
            $tipoReceitaFinanceiro->nome = $request->nome;

            if($tipoReceitaFinanceiro->save()){
                return response()->json([
                    'status' => true,
                    'msg' => 'Tipo de receita atualizada com sucesso!',
                    'tipoReceita' => $tipoReceitaFinanceiro
                ]);
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
