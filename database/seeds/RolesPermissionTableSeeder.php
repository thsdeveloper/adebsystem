<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Redefinir funções e permissões em cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Criar as permissões
        Permission::create(['name' => 'members.all']);
        Permission::create(['name' => 'members.detail']);
        Permission::create(['name' => 'members.created']);

        Permission::create(['name' => 'secretaria.home']);
        Permission::create(['name' => 'secretaria.visitantes']);
        Permission::create(['name' => 'secretaria.cartaRecomendacao']);

        Permission::create(['name' => 'financeiro.home']);
        Permission::create(['name' => 'financeiro.cadastrarReceita']);
        Permission::create(['name' => 'financeiro.cadastrarDespesa']);

        Permission::create(['name' => 'setoresIgrejas.home']);
        Permission::create(['name' => 'cadastrar.igreja']);
        Permission::create(['name' => 'visualizar.igreja']);


        // Criar funções e atribuir permissões criadas
        // isso pode ser feito como instruções separadas
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'members.all',
            'members.detail',
            'members.created',
            'secretaria.home',
            'secretaria.visitantes',
            'secretaria.cartaRecomendacao',
            'financeiro.home',
            'financeiro.cadastrarReceita',
            'financeiro.cadastrarDespesa',
            'setoresIgrejas.home',
            'cadastrar.igreja',
            'visualizar.igreja',
            ]);


        $membro = Role::create(['name' => 'membro']);


        // ou pode ser feito encadeando
//        $role = Role::create(['name' => 'admin'])->givePermissionTo(['inserir membro', 'editar membro', 'excluir membro']);

//        $role = Role::create(['name' => 'super-admin']);
//        $role->givePermissionTo(Permission::all());
        $this->command->info('[Igrejas] adicionada com sucesso ao banco!');
    }
}

