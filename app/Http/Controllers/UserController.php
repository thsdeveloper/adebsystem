<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $dadosArray = ['details.maritalStatus',
            'details.schooling',
            'details.spouse',
            'trusts',
            'departments',
            'situacaoMembro',
            'details.igreja.setor',
            'details.tipoCadastro'];

        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                'name',
                'email',
                'details.cpf',
                'details.igreja.nome_igreja',
                'details.igreja.setor.nome_setor',
                'departments.name',
                'trusts.name'
            ])
            ->with($dadosArray)
            ->allowedIncludes(['details'])
            ->paginate($request->itemsPerPage);

        return response()->json($users, 200);



//
//        $dadosArray = ['details.maritalStatus',
//            'details.schooling',
//            'details.spouse',
//            'posts',
//            'situacaoMembro',
//            'details.igreja.setor',
//            'details.tipoCadastro'];
//
//        $users = user::with($dadosArray)
//            ->where('status_id', '!=', Config::get('constants.USER.MEMBRO_INATIVO'))
//            ->orderBy('created_at', 'DESC')
//            ->paginate($request->itemsPerPage); //2 - Inativo
//
//
//        return response()->json($users, 200);
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
