<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    //
    //Retorna os posts daquele usuário
    public function user(){
        return $this->belongsTo(User::class);
    }
}
