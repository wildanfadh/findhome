<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Admin',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => 'Pengembang',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
            [
                'name' => 'Umum',
                'guard_name' => 'web',
                'created_at' => now(),
            ],
        ];

        Role::insert($data);
    }
}
