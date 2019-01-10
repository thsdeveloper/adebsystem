<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::with('details.maritalStatus', 'details.schooling', 'details.spouse', 'posts')->paginate(10);
        return $users;
    }

    public function getUser(Request $request){
        return $request->user();
    }

    public function userFind(Request $request){
        $users = User::with('details.maritalStatus', 'details.schooling', 'details.spouse')->get();
    }
}
