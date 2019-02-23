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

class UserController extends Controller
{
    public function index(){
        $users = User::with('details.maritalStatus', 'details.schooling', 'details.spouse', 'posts')->get();
        return $users;
    }

    public function getUser(Request $request){
        $user = Auth::user();

        $usuario = array();
        if($user->hasRole('admin')){
            $usuario['id'] = $user->id;
            $usuario['name'] = $user->name;
            $usuario['email'] = $user->email;
            $usuario['photo_url'] = $user->photo_url;
            $usuario['role'] = 'admin';
        }else{
            $usuario['id'] = $user->id;
            $usuario['name'] = $user->name;
            $usuario['email'] = $user->email;
            $usuario['photo_url'] = $user->photo_url;
            $usuario['role'] = 'member';
        }
        return response()->json($usuario);
    }

    public function getPermission(){
        return Auth::user()->getRoleNames();
    }

    public function userFind(Request $request){
        $users = User::with('details.maritalStatus', 'details.schooling', 'details.spouse')->get();
    }

    public function getProfessions(){
        $professions = Profession::all();
        return response()->json($professions);
    }
    public function getMemberId($id){
        $member = User::where('id', $id)->first();
        return response()->json($member);
    }

    public function getMaritalStatus(){
        $maritalStatus = MaritalStatu::all();
        return response()->json($maritalStatus);
    }
    public function getTrusts(){
        $trusts = Trust::all();
        return response()->json($trusts);
    }

    public function store(Request $request){
        $state = State::where('uf', $request->state)->first();
        $city = City::where('name', $request->city)->first();

        DB::beginTransaction();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;

        if($user->save()){
            $user_detail = new UserDetail();
            $user_detail->date_birth =  $request->date_birth;
            $user_detail->mother_name =  $request->mother_name;
            $user_detail->dad_name =  $request->dad_name;
            $user_detail->cpf =  $request->cpf;
            $user_detail->rg =  $request->rg;
            $user_detail->gender_id =  $request->gender;
            $user_detail->profession_id =  $request->profession;
            $user_detail->phone =  $request->phone;
            $user_detail->user_id = $user->id;
            $user_detail->marital_status_id = $request->marital_status;
            //$user_detail->spouse_id = 2;
            $user_detail->schooling_id = $request->schooling;
            $user_detail->date_conversion = $request->date_conversion;

            if($user_detail->save()){
                $address = new Address();
                $address->cep =  $request->cep;
                $address->state_id = $state->id;
                $address->city_id = $city->id;
                $address->address = $request->address;
                $address->number = $request->number;
                $address->neighborhood = $request->neighborhood;
                $address->user_id = $user->id;
                if($address->save()){
                    foreach($request->departments as $departamento){
                        $userDepartment = new UserDepartment();
                        $userDepartment->user_id =  $user->id;
                        $userDepartment->department_id =  $departamento;
                        $userDepartment->save();
                    }
                    foreach($request->trusts as $trust){
                        $UserTrust = new UserTrust();
                        $UserTrust->user_id =  $user->id;
                        $UserTrust->trust_id = $trust;
                        $UserTrust->save();
                    }
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'msg' => 'Membro cadastrado com sucesso!',
                        'user' => $user
                    ]);
                }
            }
        }
    }

    public function getGenders(){
        $genders = Gender::all();
        return response()->json($genders);
    }

    public function getSchoolings(){
        $schoolings = Schooling::all();
        return response()->json($schoolings);
    }

}
