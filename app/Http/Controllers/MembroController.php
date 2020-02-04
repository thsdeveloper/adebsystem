<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CargosMinisteriais;
use App\Models\City;
use App\Models\Gender;
use App\Models\MaritalStatu;
use App\Models\Profession;
use App\Models\Schooling;
use App\Models\SituacoesMembro;
use App\Models\State;
use App\Models\TiposCadastros;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MembroController extends Controller
{
    public function inserir(Request $request)
    {
        $chars = array(".", "/", "-", "(", ")");
        $cpf = str_replace($chars, "", $request->cpf);
        $cep = str_replace($chars, "", $request->cep);
        $telefone = $request->phone;

        try {
            $validator = Validator::make(array('cpf' => $cpf, 'email' => $request->email), [
                'cpf' => 'required|unique:user_details|cpf|max:11',
                'email' => 'required|unique:users',
            ]);


            if ($validator->fails()) {
                $response_json = [
                    "code" => "REG003",
                    "msg" => "Um erro ocorreu na validação dos campos.",
                    "erros" => $validator->errors()->all()
                ];
                return response()->json($response_json, 422);

            }


            $state = State::where('uf', $request->uf)->first();
            $city = City::where('name', $request->cidade)->first();

            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->matricula = $user->getMatriculaMembro();
            $user->status_id = $request->status_id;
            $user->password = Hash::make($cpf);

            //Cadastro de Imagem no Perfil
            if ($request->fotoBase64 != null) {
                //get the base-64 from data
                $base64_str = substr($request->fotoBase64, strpos($request->fotoBase64, ",") + 1);

                //decode base64 string
                $image = base64_decode($base64_str);

                //Nome do arquivo para salvar no temp
                $nomeArquivo = $cpf . '.png';

                if (Storage::disk('local')->put('/temp/' . $nomeArquivo, $image)) {
                    //Obtenho o path do arquivo
                    $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
                    $user->addMedia($storagePath . '/temp/' . $nomeArquivo)->toMediaCollection('profile');
                }
            }


            if ($user->save()) {
                $address = new Address();
                $address->cep = $cep;
                $address->state_id = $state->id;
                $address->city_id = $city->id;
                $address->address = $request->address;
                $address->number = $request->numero;
                $address->neighborhood = $request->bairro;
                $address->user_id = Auth::user()->id;

                if ($address->save()) {
                    $user_detail = new UserDetail();
                    $user_detail->user_id = $user->id;
                    $user_detail->tipo_cadastro_id = $request->tipo_cadastro_id;
                    $user_detail->data_nascimento = $request->data_nascimento;
                    $user_detail->cpf = $cpf;
                    $user_detail->rg = $request->rg;
                    $user_detail->gender_id = $request->gender_id;
                    $user_detail->profession_id = $request->profession_id;
                    $user_detail->phone = $telefone;
                    $user_detail->marital_status_id = $request->marital_status_id;
                    $user_detail->nome_conjuge = $request->nome_conjuge;
                    $user_detail->nome_pai = $request->nome_pai;
                    $user_detail->nome_mae = $request->nome_mae;
                    $user_detail->data_conversao = ($request->data_conversao !== null ? $request->data_conversao : null);
                    $user_detail->data_batismo = ($request->data_batismo !== null ? $request->data_batismo : null);
                    $user_detail->schooling_id = $request->schooling_id;
                    $user_detail->forma_ingresso_id = $request->forma_ingresso_id;
                    $user_detail->observacao = $request->observacao;
                    $user_detail->igreja_id = $request->igreja_id;
                    $user_detail->endereco_id = $address->id;

                    if ($request->tipo_cadastro_id == 1) {
                        $state_naturalidade = State::where('uf', $request->uf_naturalidade)->first();
                        $cidade_naturalidade = City::where('name', $request->cidade_naturalidade)->first();

                        $user_detail->cargo_ministerial_id = $request->cargo_ministerial_id;
                        $user_detail->uf_naturalidade_id = $state_naturalidade->id;
                        $user_detail->cidade_naturalidade_id = $cidade_naturalidade->id;
                        $user_detail->data_consagracao = ($request->data_consagracao !== null ? $request->data_consagracao : null);
                        $user_detail->curso_teologico_id = $request->curso_teologico_id;
                        $user_detail->convencao_igreja = $request->convencao_igreja;
                        $user_detail->cod_comadebg = $request->cod_comadebg;
                        $user_detail->cod_cgadb = $request->cod_cgadb;
                        $user_detail->situacao_ministerio_id = $request->situacao_ministerio_id;
                    }

                    $user->igreja()->attach($request->igreja_id);
                    $user->departments()->attach($request->departments);
                    $user->trusts()->attach($request->trusts);

                    if ($user_detail->save()) {
                        DB::commit();
                        return response()->json([
                            'status' => true,
                            'msg' => 'Membro cadastrado com sucesso!',
                            'user' => $user
                        ]);
                    }
                }
            }


        } catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }

    }

    public function visualizarMembroPorId($id)
    {
        $member = User::where('id', $id)->with('addresses',
            'details.profession',
            'details.departamentos',
            'details.cargos',
            'details.igreja.setor',
            'details.endereco')->first();

        return response()->json($member);
    }

    public function getTiposCadastros()
    {
        $tipos_cadastros = TiposCadastros::all();
        return response()->json($tipos_cadastros);
    }

    public function getCargosMinisteriais()
    {
        $cargos = CargosMinisteriais::all();
        return response()->json($cargos);
    }

    public function desativarMembro(Request $request)
    {
        $membro = User::find($request->id_membro);
        if ($membro->delete()) {
            DB::table('users')->where('id', $membro->id)->update(['status_id' => Config::get('constants.USER.MEMBRO_INATIVO')]);
            return response()->json($membro);
        }
        return false;
    }

    public function situacoesMembros()
    {
        $situacoesMembro = SituacoesMembro::all();
        return response()->json($situacoesMembro);
    }

    public function getTesoureiros(Request $request)
    {
        dd($request->all());
    }

    public function getTiposEstadoCivil()
    {
        $maritalStatus = MaritalStatu::all();
        return response()->json($maritalStatus);
    }

    public function getGeneros()
    {
        $genders = Gender::all();
        return response()->json($genders);
    }

    public function getNiveisEscolaridade()
    {
        $schoolings = Schooling::all();
        return response()->json($schoolings);
    }

    public function getCadastroCpf(Request $request)
    {
        $chars = array(".", "/", "-", "(", ")");
        $cpf = str_replace($chars, "", $request->cpf);
        $userDetail = UserDetail::where('cpf', $cpf)->first();

        if ($userDetail) {
            return response()->json(true);
        }

        return response()->json(false);
    }

}
