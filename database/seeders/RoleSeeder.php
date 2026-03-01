<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            [
                "name" => "adm",
                "description" => "Acesso total ao sistema",
                "active" => 1,
                "system" => 1
            ],
            [
                "name" => "user",
                "description" => "Acesso limitado às funções de usuário",
                "active" => 1,
                "system" => 1
            ]
        ];

        foreach ($roles as $roleData) {
            // Usamos o 'name' como identificador único para decidir se cria ou atualiza
            Role::updateOrCreate(
                ['name' => $roleData['name']], 
                $roleData
            );
        }
    }
}