<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use App\Models\Gender;
use App\Models\MaritalStatu;
use App\Models\Profession;
use App\Models\Schooling;
use App\Models\State;
use App\Models\Trust;
use App\Models\User;
use App\Models\UserDepartment;
use App\Models\UserDetail;
use App\Models\UserTrust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('details.maritalStatus', 'details.schooling', 'details.spouse', 'posts')->get();
        return $users;
    }

    public function getUser(Request $request)
    {
        $user = Auth::user();

        $usuario = array();
        if ($user->hasRole('admin')) {
            $usuario['id'] = $user->id;
            $usuario['name'] = $user->name;
            $usuario['email'] = $user->email;
            $usuario['photo_url'] = $user->photo_url;
            $usuario['role'] = 'admin';
        } else {
            $usuario['id'] = $user->id;
            $usuario['name'] = $user->name;
            $usuario['email'] = $user->email;
            $usuario['photo_url'] = $user->photo_url;
            $usuario['role'] = 'member';
        }
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

    public function getProfessions()
    {
        $professions = Profession::all();
        return response()->json($professions);
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

    public function getTrusts()
    {
        $trusts = Trust::all();
        return response()->json($trusts);
    }

    public function store(Request $request)
    {
//        dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
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
                $user->status = $request->status;
                $user->password = 'mudar123';

                if ($user->save()) {
                    $user_detail = new UserDetail();
                    $user_detail->date_birth = $request->date_birth;
                    $user_detail->forma_ingresso = $request->forma_ingresso;
//            $user_detail->dad_name =  $request->dad_name;
                    $user_detail->cpf = $request->cpf;
                    $user_detail->rg = $request->rg;
                    $user_detail->gender_id = $request->gender;
                    $user_detail->profession_id = $request->profession;
                    $user_detail->phone = $request->phone;
                    $user_detail->user_id = $user->id;
                    $user_detail->marital_status_id = $request->marital_status;
                    //$user_detail->spouse_id = 2;
                    $user_detail->schooling_id = $request->schooling;
                    $user_detail->date_conversion = $request->date_conversion;

                    if ($user_detail->save()) {
                        $address = new Address();
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

}
