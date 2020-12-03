<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\RolePermissions;
use App\Models\User;
use App\Models\UserRole;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'login' => 'pazzitiv',
            'email' => 'pazzitiv@gmail.com',
            'password' => Hash::make('5915649'),
            'active' => true,
        ]);
        User::create([
            'id' => 2,
            'login' => 'test',
            'email' => 'pazzitiv2@gmail.com',
            'password' => Hash::make('5915649'),
            'active' => true,
        ]);
        Role::create([
            'id' => 1,
            'code' => 'admin',
            'name' => 'Администратор',
        ]);
        Role::create([
            'id' => 2,
            'code' => 'user',
            'name' => 'Пользователь',
        ]);
        UserRole::create([
            'user_id' => 1,
            'role_id' => 1,
        ]);
        UserRole::create([
            'user_id' => 2,
            'role_id' => 2,
        ]);
        RolePermissions::create([
            'role_id' => 1,
            'module' => 'admin',
            'create' => true,
            'read' => true,
            'update' => true,
            'delete' => true,
        ]);
        RolePermissions::create([
            'role_id' => 2,
            'module' => 'admin',
            'create' => false,
            'read' => false,
            'update' => false,
            'delete' => false,
        ]);
    }
}
