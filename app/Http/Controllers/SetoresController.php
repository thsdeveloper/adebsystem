<?php

namespace App\Http\Controllers;

use App\Models\Setor;

class SetoresController extends Controller
{
    public function getAll(){
        $setores = Setor::all();
        return response()->json($setores);
    }
}
