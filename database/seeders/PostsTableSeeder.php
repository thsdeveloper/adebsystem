<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create('pt_BR');
        factory('App\Post', 10)->create();
        $this->command->info('[Posts] adicionado com sucesso ao banco!');
    }


}
