<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\City;
use App\Models\Gender;
use App\Models\MaritalStatu;
use App\Models\Schooling;
use App\Models\SituacoesMembro;
use App\Models\State;
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
use function GuzzleHttp\Promise\all;

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

    public function getPastores(Request $request){
        $pastores = User::whereHas('details', function ($query){
            $query->where('tipo_cadastro_id', '=', 1);
        })->get();
        return response()->json($pastores);
    }

}
