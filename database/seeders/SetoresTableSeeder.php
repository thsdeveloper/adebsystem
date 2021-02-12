<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SetoresTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
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
