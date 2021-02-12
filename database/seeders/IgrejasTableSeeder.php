<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IgrejasTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('igrejas')->insert([
            [
                'pr_user_id' => 1,
                'co_pr_user_id' => 1,
                'endereco_id' => null,
                'setor_id' => 1,
                'nome_igreja' => "ADEB - 312 Samamabaia Sul",
            ],
        ]);
        $this->command->info('[Igrejas] adicionada com sucesso ao banco!');

        DB::table('user_details')->update(['igreja_id' => 1]);
        $this->command->info('[Igrejas inseridas no membro] adicionada com sucesso ao banco!');
    }
}
