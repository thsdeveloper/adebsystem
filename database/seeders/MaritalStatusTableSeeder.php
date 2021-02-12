<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('user_details', 'marital_status')->truncate();
        DB::table('marital_status')->insert([
            ['name' => 'Solteiro(a)', 'description' => 'Uma pessoa sem atribuições legais', 'status' => 1],
            ['name' => 'Casado(a)', 'description' => 'Que se encontra no estado de matrimônio.', 'status' => 1],
            ['name' => 'Viúvo(a)', 'description' => 'Cujo cônjuge morreu, e não casou de novo', 'status' => 1],
            ['name' => 'Separado(a) judicialmente', 'description' => ' separação judicial pode ser considerada uma etapa antes do divórcio', 'status' => 1],
            ['name' => 'Divorciado(a)', 'description' => 'Será conseguido se o casal já estiver separado judicialmente há um ano', 'status' => 1]
        ]);
        $this->command->info('[Estado Civil] adicionado com sucesso ao banco!');

        DB::table('situacoes_membros')->insert([
            ['nome' => 'Ativo'],
            ['nome' => 'Inativo'],
            ['nome' => 'Desligado por pedido'],
            ['nome' => 'Desligado por Ausência'],
            ['nome' => 'Desligado por Óbito'],
            ['nome' => 'Jubilado'],
            ['nome' => 'Disciplina Temporária'],
        ]);
        $this->command->info('[Situações dos membros] adicionado com sucesso ao banco!');
    }
}
