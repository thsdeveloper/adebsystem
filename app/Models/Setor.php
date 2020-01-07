<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $table = 'setores';

    public function pastorCoordenador()
    {
        return $this->hasOne(User::class, 'id', 'pr_cord_setor_user_id');
    }
}
