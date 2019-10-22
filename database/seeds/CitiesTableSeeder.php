<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
