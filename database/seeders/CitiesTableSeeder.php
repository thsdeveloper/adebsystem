<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/municipios.json');
        $data = json_decode($json);

        foreach ($data->data as $item) {
            DB::table('cities')->insert([
                [
                    'id'  => $item->Id,
                    'code' => $item->Codigo,
                    'name' => $item->Nome,
                    'uf' => $item->Uf
                ]
            ]);
        }
        $this->command->info('[Cidades] adicionado com sucesso ao banco!');
    }
}
