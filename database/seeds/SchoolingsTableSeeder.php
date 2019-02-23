<?php

use Illuminate\Database\Seeder;

class SchoolingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_details', 'schoolings')->truncate();
        DB::table('schoolings')->insert([
            'name' => 'Nível Superior',
            'description' => 'Uma descrição para o campo de superior',
            'status' => 1,
        ]);
        $this->command->info('[Escolaridade] adicionado com sucesso ao banco!');
    }
}
