<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;

class ProficoesController extends Controller
{
    public function getProficoes(Profession $profession)
    {
        $professions = $profession->orderBy('name', 'asc')->get();
        return response()->json($professions);
    }
}
