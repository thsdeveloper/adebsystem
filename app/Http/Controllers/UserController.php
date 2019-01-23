<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $users = User::with('details.maritalStatus', 'details.schooling', 'details.spouse', 'posts')->paginate(10);
        return $users;
    }

    public function getUser(Request $request){
        return $request->user();
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


}
