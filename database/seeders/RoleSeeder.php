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
            ['name' => 'Админ', 'role_type' => 1],
            ['name' => 'Менеджер', 'role_type' => 2],
            ['name' => 'Пользователь', 'role_type' => 3],
        ];

        foreach ($roles as $data) {
            Role::create([
                'name' => $data['name'],
                'role_type' => $data['role_type'],
            ]);
        }
    }
}
