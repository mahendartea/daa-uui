<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'create users',
            'edit users',
            'delete users'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $roles = [
            'adminict',
            'admindaa',
            'operator'
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Assign permissions to roles
        $adminictRole = Role::findByName('adminict');
        $admindaaRole = Role::findByName('admindaa');
        $operatorRole = Role::findByName('operator');

        // All roles have 'create users' permission
        $adminictRole->givePermissionTo('create users');
        $admindaaRole->givePermissionTo('create users');
        $operatorRole->givePermissionTo('create users');

        // Create users with roles
        $users = [
            [
                'name' => 'Mahendar',
                'email' => 'mahendar@uui.ac.id',
                'password' => bcrypt('password'),
                'role' => 'adminict'
            ],
            [
                'name' => 'Eva Rosdiana',
                'email' => 'eva@uui.ac.id',
                'password' => bcrypt('password'),
                'role' => 'admindaa'
            ],
            [
                'name' => 'Yeni',
                'email' => 'yeni@uui.ac.id',
                'password' => bcrypt('password'),
                'role' => 'operator'
            ],
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);

            $user = User::create($userData);
            $user->assignRole($role);
        }
    }
}
