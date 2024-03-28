<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;


class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::updateOrCreate([
            'name' => 'read.user',
            'guard_name' => 'web',
        ], [
            'title' => 'Visualizar Usuários',
        ]);

        Permission::updateOrCreate([
            'name' => 'can.player',
            'guard_name' => 'web',
        ], [
            'title' => 'Pode Jogar',
        ]);

        Permission::updateOrCreate([
            'name' => 'view.admin',
            'guard_name' => 'web',
        ], [
            'title' => 'Pode acessar admin',
        ]);

        Role::updateOrCreate([
            'name' => 'banned',
            'guard_name' => 'web',
        ], [
            'title' => 'Banido',
        ]);

        Role::updateOrCreate([
            'name' => 'fake',
            'guard_name' => 'web',
        ], [
            'title' => 'Fake',
        ])->givePermissionTo('can.player');

        Role::updateOrCreate([
            'name' => 'player',
            'guard_name' => 'web',
        ], [
            'title' => 'Jogador',
        ])->givePermissionTo('can.player');

        Role::updateOrCreate([
            'name' => 'youtuber',
            'guard_name' => 'web',
        ], [
            'title' => 'Youtuber',
        ]);

        Role::updateOrCreate([
            'name' => 'affiliate',
            'guard_name' => 'web',
        ], [
            'title' => 'Afiliado',
        ]);

        Role::updateOrCreate([
            'name' => 'moderator',
            'guard_name' => 'web',
        ], [
            'title' => 'Moderador',
        ]);

        Role::updateOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ], [
            'title' => 'Administrador',
        ])->permissions()->sync(Permission::all());

    }
}
