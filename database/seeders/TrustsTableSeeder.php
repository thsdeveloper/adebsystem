<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TrustsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('trusts')->truncate();
        DB::table('trusts')->insert([
            ['name' => 'Missionário(a)'],
            ['name' => 'Líder de Departamento'],
            ['name' => 'Tesoureiro(a)'],
            ['name' => 'Secretário(a)'],
            ['name' => 'Professor(a)'],
            ['name' => 'Recepcionista'],
            ['name' => 'Técnico de áudio'],
            ['name' => 'Regente'],
            ['name' => 'Auxiliar'],
            ['name' => 'Músico'],
            ['name' => 'Cozinheiro'],
            ['name' => 'Zelador'],
        ]);
        $this->command->info('[Departamentos] adicionado com sucesso ao banco!');
    }
}
