<?php

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $user_details;
    /**
     * @var \Faker\Generator
     */
    private $faker;
    public $user;

    public function run()
    {
        $user = new User();
        $this->user_details = UserDetail::all();
        $this->faker = FactoryFaker::create('pt_BR');

        $this->createAdmins();
        $this->createUsers();
    }

    private function createAdmins()
    {
        $admin = User::create([
            'email' => 'admin@gmail.com',
            'name' => 'Admin Geral do Sistema',
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt('admin123456')
        ]);
        $admin->assignRole('admin');
        //########################################################
        $orcival = User::create([
            'email' => 'presidente@gmail.com',
            'name' => 'Presidente do Ministério',
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt('presidente123456')
        ]);
//        $orcival->assignRole($role);
        //########################################################
        $coordenador_setorial = User::create([
            'email' => 'coordenador_setorial@gmail.com',
            'name' => 'Pr. Coordenador Setorial',
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt('coordenador123456')
        ]);
//        $coordenador_setorial->assignRole($role);
        //########################################################
        $coordenador_dep_geral = User::create([
            'email' => 'coordenador_dep_geral@gmail.com',
            'name' => 'Coordenador de Departamento Geral',
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt('coordenador123456')
        ]);
//        $coordenador_setorial->assignRole($role);
        //########################################################
        $coordenador_dep_setorial = User::create([
            'email' => 'coordenador_dep_setorial@gmail.com',
            'name' => 'Coordenador de Departamento Setorial',
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt('coordenador123456')
        ]);
//        $role = Role::create(['name' => 'coordenador_dep_setorial']);
//        $coordenador_dep_setorial->assignRole($role);
        //########################################################
        $secretario_geral = User::create([
            'email' => 'secretario_geral@gmail.com',
            'name' => 'Secretário Geral',
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt('secretario123456')
        ]);
//        $role = Role::create(['name' => 'secretario_geral']);
//        $secretario_geral->assignRole($role);
        //########################################################
        $secretario_setorial = User::create([
            'email' => 'secretario_setorial@gmail.com',
            'name' => 'Secretário Setorial',
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt('secretario123456')
        ]);
//        $role = Role::create(['name' => 'secretario_setorial']);
//        $secretario_setorial->assignRole($role);
        //########################################################
        $secretario_local = User::create([
            'email' => 'secretario_local@gmail.com',
            'name' => 'Secretário Local',
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt('secretario123456')
        ]);
//        $role = Role::create(['name' => 'secretario_local']);
//        $secretario_local->assignRole($role);
        //########################################################
        $membro = User::create([
            'email' => 'membro@gmail.com',
            'name' => 'Membro da ADEB',
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt('membro123456')
        ]);
//        $role = Role::create(['name' => 'membro']);
        $membro->assignRole('membro');
        //########################################################
        DB::table('user_details')->insert([
            [
                'user_id' => $admin->id,
                'marital_status_id' => 2,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 1,
                'profession_id' => 451,
                'forma_ingresso' => 1,
                'tipo_cadastro_id' => 2,
                'cargo_ministerial_id' => null,
                'igreja_id' => null,
            ],
            [
                'user_id' => $orcival->id,
                'marital_status_id' => 2,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 2,
                'profession_id' => 200,
                'forma_ingresso' => 1,
                'tipo_cadastro_id' => 1,
                'cargo_ministerial_id' => 1,
                'igreja_id' => null,
            ],
            [
                'user_id' => $coordenador_setorial->id,
                'marital_status_id' => 2,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 2,
                'profession_id' => 208,
                'forma_ingresso' => 1,
                'tipo_cadastro_id' => 1,
                'cargo_ministerial_id' => 1,
                'igreja_id' => null,
            ],
            [
                'user_id' => $coordenador_dep_geral->id,
                'marital_status_id' => 2,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 2,
                'profession_id' => 208,
                'forma_ingresso' => 1,
                'tipo_cadastro_id' => 1,
                'cargo_ministerial_id' => 1,
                'igreja_id' => null,
            ],
            [
                'user_id' => $coordenador_dep_setorial->id,
                'marital_status_id' => 2,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 2,
                'profession_id' => 208,
                'forma_ingresso' => 1,
                'tipo_cadastro_id' => 1,
                'cargo_ministerial_id' => 1,
                'igreja_id' => null,
            ],
            [
                'user_id' => $secretario_geral->id,
                'marital_status_id' => 2,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 2,
                'profession_id' => 208,
                'forma_ingresso' => 1,
                'tipo_cadastro_id' => 1,
                'cargo_ministerial_id' => 1,
                'igreja_id' => null,
            ],
            [
                'user_id' => $secretario_setorial->id,
                'marital_status_id' => 2,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 2,
                'profession_id' => 208,
                'forma_ingresso' => 1,
                'tipo_cadastro_id' => 1,
                'cargo_ministerial_id' => 1,
                'igreja_id' => null,
            ],
            [
                'user_id' => $secretario_local->id,
                'marital_status_id' => 2,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 2,
                'profession_id' => 208,
                'forma_ingresso' => 1,
                'tipo_cadastro_id' => 1,
                'cargo_ministerial_id' => 1,
                'igreja_id' => null,
            ],
            [
                'user_id' => $membro->id,
                'marital_status_id' => 2,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 2,
                'profession_id' => 208,
                'forma_ingresso' => 1,
                'tipo_cadastro_id' => 1,
                'cargo_ministerial_id' => 1,
                'igreja_id' => null,
            ]
        ]);
        $this->command->info('[Usuários Administrativos] adicionado com sucesso ao banco!');
    }

    private function createUsers()
    {
        $max = $this->faker->numberBetween(50, 50);
        //$userDetailCount = $this->user_details->count();
        for ($i = 0; $i < $max; $i++):
            $user = $this->createUser();
            // attach random roles to user
            $this->attachRoles($user);
        endfor;
        $this->command->info('[Usuários] adicionado com sucesso ao banco!');
    }

    private function createUser()
    {
        return User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt(str_random(6))
        ]);
    }

    private function attachRoles(User $user)
    {
        $number = $this->faker->numberBetween(0, 50);

        if ($number > 0):
            DB::table('user_details')->insert([
                'user_id' => $user->id,
                'marital_status_id' => 1,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 1,
                'profession_id' => 140,
                'forma_ingresso' => 1,
                'tipo_cadastro_id' => 2,
                'cargo_ministerial_id' => null,
                'igreja_id' => null,
            ]);
            $user->assignRole('membro');
        endif;
    }
}
