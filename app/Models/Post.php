<?php
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{

    //Retorna os posts daquele usuário
    public function user(){
        return $this->belongsTo(User::class);
    }
}
