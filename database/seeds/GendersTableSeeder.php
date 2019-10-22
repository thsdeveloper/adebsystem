<?php

use Illuminate\Database\Seeder;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('genders')->truncate();
        DB::table('genders')->insert([
            ['name' => 'Masculino'],
            ['name' => 'Feminino'],
        ]);
        $this->command->info('[Genders] adicionado com sucesso ao banco!');
        //
    }
}
