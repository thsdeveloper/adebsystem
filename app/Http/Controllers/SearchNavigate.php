<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchNavigate extends Controller
{
    public function getIndex(Request $request){
        $usuarios = User::search($request->input('query'))->get();

        return response()->json($usuarios);
    }

}
