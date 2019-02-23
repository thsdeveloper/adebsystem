<?php
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
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
    public function run()
    {
        $this->user_details = UserDetail::all();
        $this->faker = FactoryFaker::create('pt_BR');

        $this->createAdmins();
        $this->createUsers();
    }
    private function createAdmins()
    {

        $user = User::create([
            'email' => 'ths.pereira@gmail.com',
            'name'  => 'Thiago Pereira',
            'password' => bcrypt('qsesbs2006')
        ]);

        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role);

        $bebel = User::create([
            'email' => 'joquebetedias@gmail.com',
            'name'  => 'Joquebete Carvalho',
            'password' => bcrypt('qsesbs2006')
        ]);
        $bebel->assignRole($role);

        DB::table('user_details')->insert([
            'user_id' => $user->id,
            'marital_status_id' => 1,
            'spouse_id' => $bebel->id,
            'schooling_id' => 1,
            'date_birth' => $this->faker->date('Y-m-d'),
            'mother_name' => $this->faker->firstNameFemale,
            'dad_name' => $this->faker->firstNameMale,
            'cpf' => $this->faker->cpf(false),
            'rg' => $this->faker->rg,
            'gender_id' => 1,
            'profession' => "Analista de Sistemas",
        ]);
        Role::create(['name' => 'member']);
        $this->command->info('[Usuário Admin] adicionado com sucesso ao banco!');
    }

    private function createUsers()
    {
        $max = $this->faker->numberBetween(50, 50);
//        $userDetailCount = $this->user_details->count();
        for($i=0; $i < $max; $i++):
            $user = $this->createUser();
            // attach random roles to user
            $this->attachRoles($user);
        endfor;
        $this->command->info('[Usuários] adicionado com sucesso ao banco!');
    }
    private function createUser()
    {
        return User::create([
            'email' => $this->faker->email,
            'name'  => $this->faker->name,
            'password' => bcrypt(str_random(6))
        ]);
    }
    private function attachRoles(User $user)
    {
        $number = $this->faker->numberBetween(0, 50);

        if($number > 0):
            DB::table('user_details')->insert([
                'user_id' => $user->id,
                'marital_status_id' => 1,
                'spouse_id' => null,
                'schooling_id' => 1,
                'date_birth' => $this->faker->date('Y-m-d'),
                'mother_name' => $this->faker->firstNameFemale,
                'dad_name' => $this->faker->firstNameMale,
                'cpf' => $this->faker->cpf(false),
                'rg' => $this->faker->rg,
                'gender_id' => 1,
                'profession' => "Empresario",
            ]);
            $user->assignRole('member');
        endif;
    }
}
