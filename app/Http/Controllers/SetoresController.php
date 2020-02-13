<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use App\Models\ContaFinanceiro;
use App\Models\Igreja;
use App\Models\Setor;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SetoresController extends Controller
{
    public function getAll(){
        $setores = Setor::with('pastorCoordenador')->get();
        return response()->json($setores);
    }

    public function inserir(Request $request){
        $chars = array(".","/","-", "(", ")");
        $cep = str_replace($chars,"", $request->endereco['cep']);

        try {
            $validator = Validator::make(array('nome_setor' => $request->setor['nome_setor']), [
                'nome_setor' => 'required',
            ]);
            if ($validator->passes()) {
                $state = State::where('uf', $request->endereco['uf'])->first();
                $city = City::where('name', $request->endereco['localidade'])->first();
                DB::beginTransaction();
                $address = new Address();
                $address->cep = $cep;
                $address->state_id = $state->id;
                $address->city_id = $city->id;
                $address->address = $request->endereco['logradouro'];
                $address->number = $request->endereco['numero'];
                $address->neighborhood = $request->endereco['bairro'];
                $address->user_id = Auth::user()->id;
                $address->lat = $request->latLng['lat'];
                $address->lng = $request->latLng['lng'];

                if($address->save()){
                    $setor = new Setor();
                    $setor->user_id = Auth::user()->id;
                    $setor->pr_cord_setor_user_id = $request->setor['pr_cord_setor_user_id'];
                    $setor->endereco_id = $address->id;
                    $setor->codigo_setor = $request->setor['codigo_setor'];
                    $setor->nome_setor = $request->setor['nome_setor'];
                    if($setor->save()){

                        // Criação da Conta Financeira do setor
                        $contaFinanceiro = new ContaFinanceiro();
                        $contaFinanceiro->saldo = 0;
                        $contaFinanceiro->modelo()->associate($setor);
                        $contaFinanceiro->save();
                        DB::commit();
                        return response()->json([
                            'status' => true,
                            'msg' => 'Setor cadastrado com sucesso.',
                            'setor' => $setor
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

}
