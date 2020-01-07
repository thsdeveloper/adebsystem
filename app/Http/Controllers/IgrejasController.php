<?php

namespace App\Http\Controllers;

use App\Models\Igreja;

class IgrejasController extends Controller
{
    public function buscarIgrejasPorSetor($id_setor){
        $igrejas = Igreja::where('setor_id', $id_setor)->get();
        return response()->json($igrejas);
    }

    public function buscarIgrejas(){
        $igrejas = Igreja::with('setor', 'pastor', 'coPastor', 'endereco')->get();
        return response()->json($igrejas);
    }
}
