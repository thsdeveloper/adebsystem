<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;


class Post extends Model implements HasMedia
{
    use HasMediaTrait;

    //Retorna os posts daquele usuário
    public function user(){
        return $this->belongsTo(User::class);
    }
}
