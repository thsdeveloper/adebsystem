<?php

use Illuminate\Database\Seeder;

class SetoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('user_details', 'marital_status')->truncate();
        DB::table('setores')->insert([
            [
                'pr_cord_setor_user_id' => 1,
                'codigo_setor' => 10,
                'nome_setor' => "Setor XX",
            ],
        ]);
        $this->command->info('[Setores] adicionado com sucesso ao banco!');
    }
}
