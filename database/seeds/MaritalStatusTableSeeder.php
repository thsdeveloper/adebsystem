<?php

use Illuminate\Database\Seeder;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_details', 'marital_status')->truncate();
        DB::table('marital_status')->insert([
            'name' => 'Casado',
            'description' => 'Uma descrição para o campo de casado',
            'status' => 1,
        ]);
    }
}
