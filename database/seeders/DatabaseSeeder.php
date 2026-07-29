<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $users = [
            [
                'name' => 'Admin Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'role_id' => 1
            ],
            [
                'name' => 'Manager Managerovich',
                'email' => 'manager@manager.com',
                'password' => bcrypt('manager'),
                'role_id' => 2
            ],
            [
                'name' => 'User Userovich',
                'email' => 'user@user.com',
                'password' => bcrypt('user'),
                'role_id' => 3
            ]
        ];

        foreach ($users as $data) {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role_id' => $data['role_id'],
            ]);
        }
    }
}
