<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Igreja extends Model
{
    //
    protected $table = 'igrejas';

    public function setor()
    {
        return $this->hasOne(Setor::class, 'id', 'setor_id');
    }

    public function pastor()
    {
        return $this->hasOne(User::class, 'id', 'pr_user_id');
    }

    public function coPastor()
    {
        return $this->hasOne(User::class, 'id', 'co_pr_user_id');
    }

    public function endereco()
    {
        return $this->hasOne(Address::class, 'id', 'endereco_id');
    }
}
