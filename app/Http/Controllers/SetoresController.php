<?php

namespace App\Http\Controllers;

use App\Models\Setor;

class SetoresController extends Controller
{
    public function getAll(){
        $setores = Setor::with('pastorCoordenador')->get();
        return response()->json($setores);
    }
}
