<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Criar ou atualizar o usuário SHOW
        $userShow = User::updateOrCreate(
            ['email' => 'show@show.com'],
            [
                'name'     => 'SHOW',
                'password' => Hash::make('show'),
                'system'   => 1
            ]
        );

        // 2. Criar ou atualizar o usuário USER
        $userNormal = User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name'     => 'USER',
                'password' => Hash::make('show'),
                'system'   => 1
            ]
        );

        // --- Linkando as Roles na mão ---

        // Buscamos as roles criadas pelo RoleSeeder
        $adminRole = Role::where('name', 'Administrador')->first();
        $userRole  = Role::where('name', 'Usuário')->first();

        // Vinculamos (o sync garante que não duplique se rodar o seeder de novo)
        if ($adminRole) {
            $userShow->roles()->sync([$adminRole->id]);
        }

        if ($userRole) {
            $userNormal->roles()->sync([$userRole->id]);
        }
    }
}