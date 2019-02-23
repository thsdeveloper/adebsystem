<?php

use Illuminate\Database\Seeder;

class TrustsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('trusts')->truncate();
        DB::table('trusts')->insert([
            ['name' => 'Pastor(a)'],
            ['name' => 'Evangelísta'],
            ['name' => 'Presbítero'],
            ['name' => 'Missionário(a)'],
            ['name' => 'Diácono'],
            ['name' => 'Tesoureiro(a)'],
            ['name' => 'Secretário(a)'],
            ['name' => 'Professor(a)'],
            ['name' => 'Levita'],
            ['name' => 'Membro'],
        ]);
        $this->command->info('[Departamentos] adicionado com sucesso ao banco!');
    }
}
