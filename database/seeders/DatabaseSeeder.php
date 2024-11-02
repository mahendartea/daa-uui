<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $roles = [
            'adminict',
            'admindaa',
            'operator'
        ];

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create(['name' => $role]);
        }

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
