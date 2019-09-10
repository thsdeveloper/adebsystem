<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use App\Models\Gender;
use App\Models\MaritalStatu;
use App\Models\Schooling;
use App\Models\SituacoesMembro;
use App\Models\State;
use App\Models\Trust;
use App\Models\User;
use App\Models\UserDepartment;
use App\Models\UserDetail;
use App\Models\UserTrust;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = user::with('details.maritalStatus',
            'details.schooling',
            'details.spouse',
            'posts',
            'situacaoMembro',
            'details.igreja.setor',
            'details.tipoCadastro')
            ->where('status_id', '!=', Config::get('constants.USER.MEMBRO_INATIVO'))->orderBy('created_at', 'DESC')->paginate($request->itemsPerPage); //2 - Inativo
        return response()->json($users, 200);
    }

    public function getUser(Request $request)
    {
        $user = Auth::user();
        $usuario = array();

        $usuario['id'] = $user->id;
        $usuario['name'] = $user->name;
        $usuario['email'] = $user->email;
        $usuario['photo_url'] = $user->photo_url;
        $usuario['permissions'] = $user->getAllPermissionsAttribute();

        return response()->json($usuario);
    }

    public function getPermission()
    {
        return Auth::user()->getRoleNames();
    }

    public function userFind(Request $request)
    {
        $users = User::with('details.maritalStatus', 'details.schooling', 'details.spouse')->get();
    }

    public function getMemberId($id)
    {
        $member = User::where('id', $id)->with('addresses', 'details.profession')->first();
        return response()->json($member);
    }

    public function getMaritalStatus()
    {
        $maritalStatus = MaritalStatu::all();
        return response()->json($maritalStatus);
    }

    public function cadastrarUser(Request $request)
    {
        $chars = array(".","/","-", "(", ")");
        $cpf = str_replace($chars,"", $request->cpf);
        $cep = str_replace($chars,"", $request->cep);
        $telefone =  $request->phone;

        try {
            $validator = Validator::make(array('cpf' => $cpf, 'email' => $request->email), [
                'cpf' => 'required|unique:user_details|cpf|max:11',
                'email' => 'required|unique:users',
            ]);

            if ($validator->passes()) {
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
                    $user_detail = new UserDetail();
                    $user_detail->user_id = $user->id;
                    $user_detail->tipo_cadastro_id = $request->tipo_cadastro_id;
                    $user_detail->data_nascimento = Carbon::createFromFormat('d/m/Y', $request->data_nascimento);
                    $user_detail->cpf = $cpf;
                    $user_detail->rg = $request->rg;
                    $user_detail->gender_id = $request->gender_id;
                    $user_detail->profession_id = $request->profession_id;
                    $user_detail->phone = $telefone;
                    $user_detail->marital_status_id = $request->marital_status_id;
                    $user_detail->nome_conjuge = $request->nome_conjuge;
                    $user_detail->nome_pai = $request->nome_pai;
                    $user_detail->nome_mae = $request->nome_mae;
                    $user_detail->data_conversao = Carbon::createFromFormat('d/m/Y', $request->data_conversao);
                    $user_detail->data_batismo = Carbon::createFromFormat('d/m/Y', $request->data_batismo);
                    $user_detail->schooling_id = $request->schooling_id;
                    $user_detail->forma_ingresso_id = $request->forma_ingresso_id;
                    $user_detail->observacao = $request->observacao;
                    $user_detail->igreja_id = $request->igreja_id;

                    if($request->tipo_cadastro_id == 1){
                        $state_naturalidade = State::where('uf', $request->uf_naturalidade)->first();
                        $cidade_naturalidade = City::where('name', $request->cidade_naturalidade)->first();

                        $user_detail->cargo_ministerial_id = $request->cargo_ministerial_id;
                        $user_detail->uf_naturalidade_id = $state_naturalidade->id;
                        $user_detail->cidade_naturalidade_id = $cidade_naturalidade->id;
                        $user_detail->data_consagracao = ($request->data_consagracao !== null ? Carbon::createFromFormat('d/m/Y', $request->data_consagracao) : null);
                        $user_detail->curso_teologico_id = $request->curso_teologico_id;
                        $user_detail->convencao_igreja = $request->convencao_igreja;
                        $user_detail->cod_comadebg = $request->cod_comadebg;
                        $user_detail->cod_cgadb = $request->cod_cgadb;
                        $user_detail->situacao_ministerio_id = $request->situacao_ministerio_id;
                    }

                    $user->igreja()->attach($request->igreja_id);

                    if ($user_detail->save()) {
                        $address = new Address();
                        $address->cep = $cep;
                        $address->state_id = $state->id;
                        $address->city_id = $city->id;
                        $address->address = $request->address;
                        $address->number = $request->numero;
                        $address->neighborhood = $request->bairro;
                        $address->user_id = $user->id;
                        if ($address->save()) {
                            $user->departments()->attach($request->departments);
                            $user->trusts()->attach($request->trusts);
                            DB::commit();
                            return response()->json([
                                'status' => true,
                                'msg' => 'Membro cadastrado com sucesso!',
                                'user' => $user
                            ]);

                        }
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

    public function getGenders()
    {
        $genders = Gender::all();
        return response()->json($genders);
    }

    public function getSchoolings()
    {
        $schoolings = Schooling::all();
        return response()->json($schoolings);
    }

    public function getSituacoesMembros()
    {
        $situacoesMembro = SituacoesMembro::all();
        return response()->json($situacoesMembro);
    }

    public function setDesativarMembro(Request $request){
        $inativo = DB::table('users')->where('id', $request->id_membro)->update(['status_id' => Config::get('constants.USER.MEMBRO_INATIVO')]);
        return response()->json($inativo);
    }

}
