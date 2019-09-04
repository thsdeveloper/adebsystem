<?php

namespace App\Http\Controllers;

use App\Models\CargosMinisteriais;
use App\Models\Profession;
use App\Models\TiposCadastros;
use Illuminate\Http\Request;

class MembroController extends Controller
{
    public function getTiposCadastros()
    {
        $tipos_cadastros = TiposCadastros::all();
        return response()->json($tipos_cadastros);
    }

    public function getCargosMinisteriais()
    {
        $cargos = CargosMinisteriais::all();
        return response()->json($cargos);
    }
}
