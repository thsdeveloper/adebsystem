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

        // Criar funções e atribuir permissões criadas
        // isso pode ser feito como instruções separadas
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['members.all', 'members.detail', 'members.created']);


        $membro = Role::create(['name' => 'membro']);


        // ou pode ser feito encadeando
//        $role = Role::create(['name' => 'admin'])->givePermissionTo(['inserir membro', 'editar membro', 'excluir membro']);

//        $role = Role::create(['name' => 'super-admin']);
//        $role->givePermissionTo(Permission::all());
        $this->command->info('[Igrejas] adicionada com sucesso ao banco!');
    }
}

