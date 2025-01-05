<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        Permission::updateOrCreate(['name' => 'Alterar Configurações']);

        Permission::updateOrCreate(['name' => 'Visualizar Usuário']);
        Permission::updateOrCreate(['name' => 'Cadastrar Usuário']);
        Permission::updateOrCreate(['name' => 'Alterar Usuário']);
        Permission::updateOrCreate(['name' => 'Excluir Usuário']);

        Permission::updateOrCreate(['name' => 'Visualizar Função']);
        Permission::updateOrCreate(['name' => 'Cadastrar Função']);
        Permission::updateOrCreate(['name' => 'Alterar Função']);
        Permission::updateOrCreate(['name' => 'Excluir Função']);

        // create roles and assign existing permissions
        Role::updateOrCreate(['name' => 'Desenvolvedor']);
        Role::updateOrCreate(['name' => 'Administrador']);
    }
}
