<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('departments')->truncate();
        DB::table('departments')->insert([
            ['name' => 'Vozes de Júbilo - UMADEB', 'leader_one_id' => 40, 'leader_two_id' => 23, 'leader_three_id' => null, 'description' => 'Departamento de jovens'],
            ['name' => 'Rio de Águas Vivas - UNAADEB', 'leader_one_id' => 35, 'leader_two_id' => 12, 'leader_three_id' => null, 'description' => 'Departamento de adolescentes'],
            ['name' => 'Gideões da Última Hora - UDVADEB', 'leader_one_id' => 36, 'leader_two_id' => 19, 'leader_three_id' => null, 'description' => 'Departamento de varões'],
            ['name' => 'Coorderinhos de Cristo - UCADEB', 'leader_one_id' => 46, 'leader_two_id' => 36, 'leader_three_id' => null, 'description' => 'Departamento de crianças'],
            ['name' => 'Ministério de Louvor', 'leader_one_id' => 1, 'leader_two_id' => 2, 'leader_three_id' => null, 'description' => 'Ministério de louvor da igreja'],
            ['name' => 'Chamas Vivas - UFADEB', 'leader_one_id' => 5, 'leader_two_id' => 8, 'leader_three_id' => null, 'description' => 'Departamento das irmãs'],
            ['name' => 'Missões - SEMADEB', 'leader_one_id' => 25, 'leader_two_id' => 28, 'leader_three_id' => null, 'description' => 'Departamento de missões'],
        ]);
        $this->command->info('[Departamentos] adicionado com sucesso ao banco!');
    }
}
