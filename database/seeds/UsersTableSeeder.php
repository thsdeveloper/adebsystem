<?php
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use Illuminate\Support\Facades\Schema;
class UsersTableSeeder extends Seeder
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $roles;
    /**
     * @var \Faker\Generator
     */
    private $faker;
    public function run()
    {
        // Apaga toda a tabela de usuários
        DB::table('oauth_providers', 'users')->truncate();
//        $this->roles = Role::all();
        $this->faker = FactoryFaker::create('pt_BR');
        // Cria usuários admins (dados controlados)
        $this->createAdmins();
        // Cria usuários demo dados faker
        $this->createUsers();

    }
    private function createAdmins()
    {
//        $superuserRole = $this->roles->where('name', 'superuser')->first();
        $user = User::create([
            'email' => 'ths.pereira@gmail.com',
            'name'  => 'Thiago Pereira',
            'password' => bcrypt('qsesbs2006')
        ]);
        $bebel = User::create([
            'email' => 'joquebetedias@gmail.com',
            'name'  => 'Joquebete Carvalho',
            'password' => bcrypt('qsesbs2006')
        ]);
        // attach user_details
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
            'sex' => "Masculino",
            'profession' => "Analista de Sistemas",
        ]);
//        $user->attachRole($superuserRole);

        $this->command->info('User ths.pereira@gmail.com created');
    }

    private function createUsers()
    {
        $max = $this->faker->numberBetween(100, 200);
//        $rolesCount = $this->roles->count();
        for($i=0; $i < $max; $i++):
            $user = $this->createUser();
            // attach random roles to user
//            $this->attachRoles($user, $rolesCount);
        endfor;
        $this->command->info($max . ' demo users created');
    }
    private function createUser()
    {
        return User::create([
            'email' => $this->faker->email,
            'name'  => $this->faker->name,
            'password' => bcrypt(str_random(6))
        ]);
    }
    private function attachRoles(User $user, $rolesCount)
    {
        $number = $this->faker->numberBetween(0, $rolesCount);

        if($number > 0):
            $roles = collect($this->roles->random($number))->lists('id')->toArray();
            $user->roles()->sync($roles);
        endif;
    }
}
