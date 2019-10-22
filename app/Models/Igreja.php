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
}
