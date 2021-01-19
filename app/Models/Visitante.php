<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Visitante extends Model
{
    use Notifiable;

    //Retorna o usuário que criou daquele visitante
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function routeNotificationForNexmo($notification)
    {
        $phone = preg_replace("/[^0-9]/", "", $this->telefone);
        $codeArea = '55';
        return $codeArea.$phone;
    }
}
