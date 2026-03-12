<?php

namespace App\Actions\Api;

use App\Enums\TipoUsuario;
use App\Models\Role;
use App\Models\User;

class CreateNewUser
{
    public static function create(array $params)
    {
        $existeRoleTutor = Role::where('name', 'tutor')->exists();

        if (!$existeRoleTutor) {
            Role::create(['name' => 'tutor']);
        }

        $existeRoleVeterinario = Role::where('name', 'veterinario')->exists();
        if (!$existeRoleVeterinario) {
            Role::create(['name' => 'veterinario']);
        }

        $user = User::create([
            'name'     => $params['name'],
            'email'    => $params['email'],
            'password' => $params['password'],
        ]);

        if ($params['tipoUsuario'] === TipoUsuario::VETERINARIO->value) {
            $user->addRole('veterinario');
        } else {
            $user->addRole('tutor');
        }

        return $user;
    }
}
