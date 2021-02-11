<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    //Retorna o estado civil do usuário
    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatu::class);
    }

    //Retorna a escolaridade do usuário
    public function schooling()
    {
        return $this->belongsTo(Schooling::class);
    }

    //Retorna a escolaridade do usuário
    public function spouse()
    {
        return $this->belongsTo(User::class);
    }

    //Retorna a escolaridade do usuário
    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function departamentos()
    {
        return $this->belongsToMany(Departments::class, 'users_departments', 'user_id', 'department_id');
    }

    public function cargos()
    {
        return $this->belongsToMany(Trust::class, 'user_trusts', 'user_id', 'trust_id');
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

    public function endereco()
    {
        return $this->hasOne(Address::class, 'id', 'endereco_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function scopeAniversariantesEntre($query, $dataInicio, $dataFim)
    {
//        $query = $this->user();
        $mesDeInicio = explode('-', $dataInicio)[0];
        $diaDeInicio = explode('-', $dataInicio)[1];
        $mesFinal = explode('-', $dataFim)[0];
        $diaFinal = explode('-', $dataFim)[1];
        $anoAtual = date('Y');

        //Cria um período de data para procurar aniversariantes;
        $period = CarbonPeriod::create("$anoAtual-$mesDeInicio-$diaDeInicio", "$anoAtual-$mesFinal-$diaFinal");


        foreach ($period as $key => $date) {
            $queryFn = function ($query) use ($date) {
                $query
                    ->whereMonth("data_nascimento", '=', $date->format('m'))
                    ->whereDay("data_nascimento", '=', $date->format('d'))
                    ->with('user', 'igreja')->orderBy('data_nascimento', 'asc');
            };

            if ($key === 0) {
                $queryFn($query);
            } else {
                $query->orWhere(function ($q) use ($queryFn) {
                    $queryFn($q);
                });
            }
        }

        return $query;
    }


}
