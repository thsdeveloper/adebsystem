<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'departments';

    public function leaderOne(){
        return $this->hasOne(User::class, 'id', 'leader_one_id');
    }

    public function leaderTwo(){
        return $this->hasOne(User::class, 'id', 'leader_two_id');
    }

    public function leaderThree(){
        return $this->hasOne(User::class, 'id', 'leader_three_id');
    }
}
