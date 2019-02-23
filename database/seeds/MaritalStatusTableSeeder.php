<?php

use Illuminate\Database\Seeder;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_details', 'marital_status')->truncate();
        DB::table('marital_status')->insert([
            ['name' => 'Solteiro', 'description' => 'Uma pessoa sem atribuições legais', 'status' => 1],
            ['name' => 'Casado', 'description' => 'Que se encontra no estado de matrimônio.', 'status' => 1],
            ['name' => 'Viúvo', 'description' => 'Cujo cônjuge morreu, e não casou de novo', 'status' => 1],
            ['name' => 'Separado judicialmente', 'description' => ' separação judicial pode ser considerada uma etapa antes do divórcio', 'status' => 1],
            ['name' => 'Divorciado', 'description' => 'Será conseguido se o casal já estiver separado judicialmente há um ano', 'status' => 1]
        ]);
        $this->command->info('[Estado Civil] adicionado com sucesso ao banco!');
    }
}
