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
        DB::table('user_details')->insert([
            [
                'user_id' => $admin->id,
                'marital_status_id' => 2,
                'schooling_id' => 1,
                'data_nascimento' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 1,
                'profession_id' => 451,
                'forma_ingresso_id' => 1,
                'tipo_cadastro_id' => 2,
                'cargo_ministerial_id' => null,
                'igreja_id' => null,
            ],
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
                'marital_status_id' => 2,
                'schooling_id' => 1,
                'data_nascimento' => $this->faker->date('Y-m-d'),
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 1,
                'profession_id' => 451,
                'forma_ingresso_id' => 1,
                'tipo_cadastro_id' => 2,
                'cargo_ministerial_id' => null,
                'igreja_id' => null,
            ]);
            $user->assignRole('membro');
        endif;
    }
}
