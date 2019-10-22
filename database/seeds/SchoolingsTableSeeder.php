<?php

use Illuminate\Database\Seeder;

class SchoolingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_details', 'schoolings')->truncate();
        DB::table('schoolings')->insert([
            [
                'name' => 'Analfabeto',
                'description' => 'indivíduo que não sabe ler e escrever;',
                'status' => 1,
            ],
            [
                'name' => 'Ensino fundamental incompleto',
                'description' => 'não concluiu todos os anos correspondentes a este ciclo de estudos (1ª a 9ª série)',
                'status' => 1,
            ],
            [
                'name' => 'Ensino fundamental completo',
                'description' => 'concluiu o ciclo de estudos básicos (1ª a 9ª série)',
                'status' => 1,
            ],
            [
                'name' => 'Ensino médio incompleto',
                'description' => 'concluiu este ciclo de estudos (1º ao 3º ano)',
                'status' => 1,
            ],
            [
                'name' => 'Ensino médio completo',
                'description' => 'concluiu este ciclo de estudos (1º ao 3º ano)',
                'status' => 1,
            ],
            [
                'name' => 'Superior completo (ou graduação)',
                'description' => 'concluiu o curso de ensino superior (bacharelado ou licenciatura)',
                'status' => 1,
            ],
            [
                'name' => 'Pós-graduação',
                'description' => 'especialização no âmbito do curso de ensino superior que foi concluído',
                'status' => 1,
            ],
            [
                'name' => 'Mestrado',
                'description' => 'pós-graduação que garante o grau de mestre em determinada área',
                'status' => 1,
            ],
            [
                'name' => 'Doutorado',
                'description' => 'pós-graduação que garante o grau de doutor em determinada área de pesquisa',
                'status' => 1,
            ],
            [
                'name' => 'Pós-Doutorado',
                'description' => 'atividade de pesquisa ou estágio que pode ser realizada após a conclusão do doutorado.',
                'status' => 1,
            ],
        ]);
        $this->command->info('[Escolaridade] adicionado com sucesso ao banco!');
    }
}
