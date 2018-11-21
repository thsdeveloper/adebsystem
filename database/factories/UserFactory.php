<?php

use App\Models\User;
use App\Models\UserDetail;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(UserDetail::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'marital_status_id' => 1,
        'spouse_id' => 1,
        'schooling_id' => 1,
        'date_birth' => $faker->date('Y-m-d'),
        'mother_name' => $faker->firstNameFemale,
        'dad_name' => $faker->firstNameMale,
        'cpf' => $faker->cpf(false),
        'rg' => $faker->rg,
        'sex' => "Masculino",
        'profession' => "Analista de Sistemas",

    ];
});
