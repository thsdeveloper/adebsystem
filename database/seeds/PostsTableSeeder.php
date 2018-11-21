<?php

use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create('pt_BR');
        factory('App\Post', 10)->create();
    }


}
