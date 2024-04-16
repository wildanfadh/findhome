<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ========== Admin ==========
        $userAdmin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'Admin@mail.com',
            'password' => Hash::make('administrator'),
            'created_at' => now()
        ]);

        $roleAdmin = Role::where('name', 'Admin')->first();

        $userAdmin->assignRole([$roleAdmin->id]);
        // ========== End Admin ==========

        // ========== Umum ==========
        $userUmum = User::create([
            'name' => 'Pembeli 1 (Test)',
            'username' => 'pembeli1',
            'email' => 'pembeli@mail.com',
            'password' => Hash::make('pembeli'),
            'created_at' => now()
        ]);

        $roleUmum = Role::where('name', 'Umum')->first();

        $userUmum->assignRole([$roleUmum->id]);
        // ========== End Umum ==========
    }
}
