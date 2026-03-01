<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $permissoes = [
        // Permissões de Usuários
        'users.view', 'users.create', 'users.edit', 'users.delete',
        // Permissões de Cargos (Roles)
        'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
        // Permissões de Configurações
        'configs.view', 'configs.edit',
    ];

    foreach ($permissoes as $permissao) {
        \App\Models\Permission::firstOrCreate(['name' => $permissao]);
    }
}
}
