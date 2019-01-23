<?php

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/regions.json');
        $data = json_decode($json);

        foreach ($data->data as $item) {
            DB::table('regions')->insert([
                [
                    'id'  => $item->Id,
                    'name' => $item->Nome
                ]
            ]);
        }
        $this->command->info('[Regiões] adicionado com sucesso ao banco!');
    }
}
