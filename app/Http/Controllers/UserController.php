<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use App\Models\Gender;
use App\Models\MaritalStatu;
use App\Models\Profession;
use App\Models\Schooling;
use App\Models\SituacoesMembro;
use App\Models\State;
use App\Models\Trust;
use App\Models\User;
use App\Models\UserDepartment;
use App\Models\UserDetail;
use App\Models\UserTrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(request $request)
    {
//        dd($request->all());
        $users = user::with('details.maritalstatus',
            'details.schooling',
            'details.spouse',
            'posts',
            'situacaomembro',
            'details.igreja.setor',
            'details.tipocadastro')->paginate($request->itemsPerPage);
        return response()->json($users, 200);
    }

    public function getuser(request $request)
    {
        $user = auth::user();
        $usuario = array();

        $usuario['id'] = $user->id;
        $usuario['name'] = $user->name;
        $usuario['email'] = $user->email;
        $usuario['photo_url'] = $user->photo_url;
        $usuario['permissions'] = $user->getallpermissionsattribute();

        return response()->json($usuario);
    }

    public function getpermission()
    {
        return auth::user()->getrolenames();
    }

    public function userfind(request $request)
    {
        $users = user::with('details.maritalstatus', 'details.schooling', 'details.spouse')->get();
    }

    public function getprofessions(profession $profession)
    {
        $professions = $profession->orderby('name', 'asc')->get();
        return response()->json($professions);
    }

    public function getmemberid($id)
    {
        $member = user::where('id', $id)->with('addresses', 'details.profession')->first();
        return response()->json($member);
    }

    public function getmaritalstatus()
    {
        $maritalstatus = maritalstatu::all();
        return response()->json($maritalstatus);
    }

    public function gettrusts()
    {
        $trusts = trust::all();
        return response()->json($trusts);
    }

    public function cadastraruser(request $request)
    {
        try {
            $validator = validator::make($request->all(), [
                'cpf' => 'required|unique:user_details|cpf|max:11',
                'email' => 'required|unique:users',
            ]);

            if ($validator->passes()) {
                $state = state::where('uf', $request->uf)->first();
                $city = city::where('name', $request->cidade)->first();

                db::begintransaction();

                $user = new user();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->status_id = $request->status_id;
                $user->password = hash::make($request->cpf);
                $user->matricula = $user->getMatriculaMembro();

                //cadastro de imagem no perfil
                if ($request->fotobase64 != null) {
                    //get the base-64 from data
                    $base64_str = substr($request->fotobase64, strpos($request->fotobase64, ",") + 1);

                    //decode base64 string
                    $image = base64_decode($base64_str);

                    //nome do arquivo para salvar no temp
                    $nomearquivo = $request->cpf . '.png';

                    if (storage::disk('local')->put('/temp/' . $nomearquivo, $image)) {
                        //obtenho o path do arquivo
                        $storagepath = storage::disk('local')->getdriver()->getadapter()->getpathprefix();
                        $user->addmedia($storagepath . '/temp/' . $nomearquivo)->tomediacollection('profile');
                    }
                }

                if ($user->save()) {
                    $user_detail = new userdetail();
                    $user_detail->tipo_cadastro_id = $request->tipo_cadastro_id;
                    $user_detail->cargo_ministerial_id = $request->cargo_ministerial_id;
                    $user_detail->date_birth = $request->date_birth;
                    $user_detail->forma_ingresso = $request->forma_ingresso;
                    $user_detail->nome_conjuge = $request->nome_conjuge;
                    $user_detail->nome_pai = $request->nome_pai;
                    $user_detail->nome_mae = $request->nome_mae;
                    $user_detail->data_batismo = $request->data_batismo;
                    $user_detail->observacoes = $request->observacoes;
                    $user_detail->cpf = $request->cpf;
                    $user_detail->rg = $request->rg;
                    $user_detail->gender_id = $request->gender;
                    $user_detail->profession_id = $request->profession;
                    $user_detail->phone = $request->phone;
                    $user_detail->user_id = $user->id;
                    $user_detail->marital_status_id = $request->marital_status;
                    $user_detail->schooling_id = $request->schooling;
                    $user_detail->date_conversion = $request->date_conversion;
                    $user_detail->igreja()->attach($request->igreja_id);

                    if ($user_detail->save()) {
                        $address = new address();
                        $address->cep = $request->cep;
                        $address->state_id = $state->id;
                        $address->city_id = $city->id;
                        $address->address = $request->address;
                        $address->number = $request->numero;
                        $address->neighborhood = $request->bairro;
                        $address->user_id = $user->id;
                        if ($address->save()) {
                            $user->departments()->attach($request->departments);
                            $user->trusts()->attach($request->trusts);
                            $user->igreja()->attach($request->igreja_id);
                            db::commit();
                            return response()->json([
                                'status' => true,
                                'msg' => 'membro cadastrado com sucesso!',
                                'user' => $user
                            ]);

                        }
                    }
                }
            } else {
                $response_json = [
                    "code" => "reg003",
                    "msg" => "um erro ocorreu na validação dos campos.",
                    "erros" => $validator->errors()->all()
                ];
                return response()->json($response_json, 422);
            }
        } catch (validationexception $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => 'error',
                'errors' => $exception->errors(),
            ], 422);
        }

    }

    public function getgenders()
    {
        $genders = gender::all();
        return response()->json($genders);
    }

    public function getschoolings()
    {
        $schoolings = schooling::all();
        return response()->json($schoolings);
    }

    public function getsituacoesmembros()
    {
        $situacoesmembro = situacoesmembro::all();
        return response()->json($situacoesmembro);
    }

}
