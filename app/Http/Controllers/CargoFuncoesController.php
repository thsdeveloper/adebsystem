<?php

namespace App\Http\Controllers;

use App\Models\CargosMinisteriais;
use App\Models\Trust;
use Illuminate\Http\Request;

class CargoFuncoesController extends Controller
{
    public function getCargosFuncoes(Trust $trust)
    {
        $dados = $trust->orderBy('name', 'asc')->get();
        return response()->json($dados);
    }
}
