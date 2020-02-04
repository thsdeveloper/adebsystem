<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use App\Models\ContaFinanceiro;
use App\Models\Igreja;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use function GuzzleHttp\Promise\all;

class IgrejasController extends Controller
{
    public function buscarIgrejasPorSetor($id_setor)
    {
        $igrejas = Igreja::where('setor_id', $id_setor)->get();
        return response()->json($igrejas);
    }

    public function buscarIgrejas()
    {
        $igrejas = Igreja::with('setor', 'pastor', 'coPastor', 'endereco')->get();
        return response()->json($igrejas);
    }

    public function visualizarIgrejaPorId(Request $request){
        $igreja = Igreja::with('setor', 'pastor', 'coPastor', 'endereco')->find($request->id);
        return response()->json($igreja);
    }

    public function cadastrarIgreja(Request $request)
    {
        $chars = array(".","/","-", "(", ")");
        $cep = str_replace($chars,"", $request->endereco['cep']);

        try {
            $validator = Validator::make(array('nome_igreja' => $request->nome_igreja), [
                'nome_igreja' => 'required',
            ]);

            if ($validator->passes()) {
                $state = State::where('uf', $request->endereco['state_id'])->first();
                $city = City::where('name', $request->endereco['city_id'])->first();

                DB::beginTransaction();

                $address = new Address();
                $address->cep = $cep;
                $address->state_id = $state->id;
                $address->city_id = $city->id;
                $address->address = $request->endereco['address'];
                $address->number = $request->endereco['number'];
                $address->neighborhood = $request->endereco['neighborhood'];
                $address->user_id = Auth::user()->id;
                $address->lat = $request->endereco['lat'];
                $address->lng = $request->endereco['lng'];

                if($address->save()){
                    $igreja = new Igreja();
                    $igreja->nome_igreja = $request->nome_igreja;
                    $igreja->setor_id = $request->setor_id;
                    $igreja->pr_user_id = $request->pr_user_id;
                    $igreja->co_pr_user_id = $request->co_pr_user_id;
                    $igreja->endereco_id = $address->id;

                    if($igreja->save()){

                        // Criação da Conta Financeira da Igreja
                        $contaFinanceiro = new ContaFinanceiro();
                        $contaFinanceiro->saldo = 0;
                        $contaFinanceiro->modelo()->associate($igreja);
                        $contaFinanceiro->save();

                        DB::commit();
                        return response()->json([
                            'status' => true,
                            'msg' => 'Igreja cadastrada com sucesso!',
                            'igreja' => $igreja
                        ]);

                    }
                }

            } else {
                $response_json = [
                    "code" => "REG003",
                    "msg" => "Um erro ocorreu na validação dos campos.",
                    "erros" => $validator->errors()->all()
                ];
                return response()->json($response_json, 422);
            }

        } catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }

    }

    public function excluir(Request $request){
        try {
            $igreja = Igreja::find($request->id);
            $igreja->delete();

            return response()->json([
                'status' => true,
                'msg' => 'Igreja excluida com sucesso!',
                'igreja' => $igreja
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }
}
