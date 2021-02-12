<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/estados.json');
        $data = json_decode($json);

        foreach ($data->data as $item) {
            DB::table('states')->insert([
                [
                    'id'  => $item->Id,
                    'code_uf'  => $item->CodigoUf,
                    'name'  => $item->Nome,
                    'uf'  => $item->Uf,
                ]
            ]);
        }
        $this->command->info('[Estados] adicionado com sucesso ao banco!');
    }
}
