<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            ['name' => 'UCADEB - Crianças', 'leader_one_id' => 1, 'leader_two_id' => 1, 'leader_three_id' => null, 'description' => 'União de Crianças da Assembleia de Deus de Brasília'],
            ['name' => 'UNAADEB - Adolescentes', 'leader_one_id' => 1, 'leader_two_id' => 1, 'leader_three_id' => null, 'description' => 'União de Adolescentes da Assembleia de Deus de Brasília'],
            ['name' => 'UMADEB - Jovens', 'leader_one_id' => 1, 'leader_two_id' => 1, 'leader_three_id' => null, 'description' => 'União de Jovens da Assembleia de Deus de Brasília'],
            ['name' => 'UFADEB - Mulheres', 'leader_one_id' => 1, 'leader_two_id' => 1, 'leader_three_id' => null, 'description' => 'União de Mulheres da Assembleia de Deus de Brasília'],
            ['name' => 'UDVADEB - Homens', 'leader_one_id' => 1, 'leader_two_id' => 1, 'leader_three_id' => null, 'description' => 'União de Homens da Assembleia de Deus de Brasília'],
            ['name' => 'UNEMADEB - Esposas de Obreiros', 'leader_one_id' => 1, 'leader_two_id' => 1, 'leader_three_id' => null, 'description' => 'União de Esposas de Obreiros da Assembleia de Deus de Brasília'],
            ['name' => 'SEMADEB - Evangelismo e Missão', 'leader_one_id' => 1, 'leader_two_id' => 1, 'leader_three_id' => null, 'description' => 'Departamento de missões'],
            ['name' => 'DEMADEB - Departamento de Música', 'leader_one_id' => 1, 'leader_two_id' => 1, 'leader_three_id' => null, 'description' => 'Departamento de Música'],
        ]);
        $this->command->info('[Departamentos] adicionado com sucesso ao banco!');
    }
}
