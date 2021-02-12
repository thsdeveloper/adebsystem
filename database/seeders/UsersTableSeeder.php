<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $user;

    public function run()
    {
        $this->createAdmins();
    }

    private function createAdmins()
    {
        $admin = User::create([
            'email' => 'admin@adebriachofundo.com.br',
            'name' => 'Pr. Wilson - Admin Geral do Sistema',
            'status_id' => 1,
            'matricula' => rand(1, 1000000),
            'password' => bcrypt('admin123456')
        ]);
        $admin->assignRole('admin');
        DB::table('user_details')->insert([
            [
                'user_id' => $admin->id,
                'marital_status_id' => 2,
                'nome_conjuge' => 'Maria Das Dores Vieira Resende',
                'nome_pai' => 'Não informado',
                'nome_mae' => 'Não informado',
                'data_batismo' => '2007-02-26',
                'observacao' => 'Cadastro Geral de Acesso',
                'schooling_id' => 6,
                'gender_id' => 1,
                'forma_ingresso_id' => 5,
                'tipo_cadastro_id' => 1,
                'cargo_ministerial_id' => 1,
                'data_nascimento' => '2007-02-26',
                'cpf' => '03863152131',
                'rg' => '2622896',
                'profession_id' => 451,
                'phone' => '(61) 9 2061-8111',
                'data_conversao' => '2007-02-26',
                'data_consagracao' => '2007-02-26',
                'data_consagracao' => '2007-02-26',
                'curso_teologico_id' => 3,
                'convencao_igreja' => 'CGADB',
                'cod_comadebg' => 'CGADB846577',
                'cod_cgadb' => 'CGADB846577654545622',
                'situacao_ministerio_id' => 2,
                'created_at' => '2007-02-26',
                'cidade_naturalidade_id' => null,
                'uf_naturalidade_id' => null,
                'igreja_id' => null,
            ],
        ]);
        $this->command->info('[Usuários Administrativos] adicionado com sucesso ao banco!');
    }
}
