<?php

namespace App\Http\Controllers;

use App\Models\Visitante;
use App\Notifications\PostNotification;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecretariaController extends Controller
{

    public function salvarVisitante(Visitante $visitante, Request $request)
    {
        $user = Auth::user();
        $visitante->user_id = $user->id;
        $visitante->nome = $request['nome'];
        $visitante->email = $request['email'];
        $visitante->telefone = $request['telefone'];
        $visitante->procurando_igreja = $request['procurando_igreja'];
        $visitante->evangelico = $request['evangelico'];
        $visitante->igreja = $request['igreja'];
        $visitante->apresentado = false;
        $visitante->observacao =  $request['observacao'];;
        $visitante->save();

        return response($visitante, 201);
    }

    public function listarVisitantes()
    {
        $visitantes = Visitante::with('user')->orderBy('created_at', 'desc')->get();
        return response($visitantes, 201);
    }
}
