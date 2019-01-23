<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
                    'region_id' => $item->Regiao
                ]
            ]);
        }
        $this->command->info('[Estados] adicionado com sucesso ao banco!');
    }
}
