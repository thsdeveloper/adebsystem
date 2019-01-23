<?php

use Illuminate\Database\Seeder;

class NeighborhoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/bairros.json');
        $data = json_decode($json);

        foreach ($data->data as $item) {
            DB::table('neighborhoods')->insert([
                [
                    'id'  => $item->Id,
                    'code'  => $item->Codigo,
                    'name'  => $item->Nome,
                    'uf'  => $item->Uf,
                ]
            ]);
        }
        $this->command->info('[Bairros] adicionado com sucesso ao banco!');
    }
}
