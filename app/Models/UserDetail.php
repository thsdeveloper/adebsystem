<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    //Retorna o estado civil do usuário
    public function maritalStatus(){
        return $this->belongsTo(MaritalStatu::class);
    }

    //Retorna a escolaridade do usuário
    public function schooling(){
        return $this->belongsTo(Schooling::class);
    }

    //Retorna a escolaridade do usuário
    public function spouse(){
        return $this->belongsTo(User::class);
    }

    //Retorna a escolaridade do usuário
    public function profession(){
        return $this->belongsTo(Profession::class);
    }


    public function igreja()
    {
        return $this->hasOne(Igreja::class, 'id', 'igreja_id');
    }

    public function tipoCadastro()
    {
        return $this->hasOne(TiposCadastros::class, 'id', 'tipo_cadastro_id');
    }

    public function cargoMinisterialPastor()
    {
        return $this->hasOne(CargosMinisteriais::class, 'id', 'cargo_ministerial_id')
            ->where('id', 1);
    }


}
