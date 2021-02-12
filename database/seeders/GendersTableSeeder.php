<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
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
