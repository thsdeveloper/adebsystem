<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Igreja extends Model
{
    use SoftDeletes;

    protected $table = 'igrejas';

    public function conta(){
        return $this->morphOne(ContaFinanceiro::class, '', 'conta_type', 'conta_id');
    }

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
