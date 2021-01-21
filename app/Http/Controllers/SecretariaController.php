<?php

namespace App\Http\Controllers;

use App\Models\Visitante;
use App\Notifications\EnviaBoasVindasVisitante;
use App\Notifications\NovoMembroNotification;
use App\Notifications\PostNotification;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use function GuzzleHttp\Promise\all;

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
        $visitante->autoriza_envio = $request['autoriza_envio'];
        $visitante->autoriza_apresentacao = $request['autoriza_apresentacao'];
        $visitante->envio_mensagem = $request['envio_mensagem'];
        if ($visitante->save()) {
            return Visitante::with('user')->orderBy('created_at', 'desc')->get();
        }
    }

    public function listarVisitantes()
    {
        $visitantes = Visitante::with('user')->orderBy('created_at', 'desc')->get();
        return response($visitantes, 200);
    }

    public function apresentarVisitante(Request $request)
    {
        foreach ($request->all() as $Modelvisitante) {
            if ($Modelvisitante['autoriza_apresentacao']) {

                DB::table('visitantes')->where('id', $Modelvisitante['id'])->update(['apresentado' => true]);

//                if ($visitante::where('id', $Modelvisitante['id'])->update(['apresentado' => true])) {
////                    return Visitante::with('user')->orderBy('created_at', 'desc')->get();
//                }
            }
        }

    }

    public function enviarNotificacoes(Request $request)
    {
        foreach ($request->all() as $Modelvisitante) {
            if ($Modelvisitante['autoriza_envio']) {
                if ($Modelvisitante['email'] || $Modelvisitante['telefone']) {
                    $visitante = Visitante::find($Modelvisitante['id']);

                    if($visitante){
                        $visitante->notify(new EnviaBoasVindasVisitante());
                        DB::table('visitantes')->where('id', $Modelvisitante['id'])->update(['envio_mensagem' => true]);
                    }

                }
            }
        }
    }
}
