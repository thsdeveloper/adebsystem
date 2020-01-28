<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContaFinanceiro extends Model
{

    protected $table = 'conta_financeiro';

    public function modelo(){
        return $this->morphTo('', 'conta_type', 'conta_id');
    }

}
