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
            'no_hp' => '0854567891230',
            'email' => 'Admin@mail.com',
            'password' => Hash::make('password'),
            'created_at' => now()
        ]);

        $roleAdmin = Role::where('name', 'Admin')->first();

        $userAdmin->assignRole([$roleAdmin->id]);
        // ========== End Admin ==========

        // ========== Umum ==========
        $userUmum = User::create([
            'name' => 'Pembeli 1 (Test)',
            'username' => 'pembeli1',
            'no_hp' => '0854567125864',
            'email' => 'pembeli@mail.com',
            'password' => Hash::make('password'),
            'created_at' => now()
        ]);

        $roleUmum = Role::where('name', 'Umum')->first();

        $userUmum->assignRole([$roleUmum->id]);
        // ========== End Umum ==========

        // ========== Pengembang ==========
        $userUmum = User::create([
            'name' => 'Pengembang 1 (Test)',
            'username' => 'pengembang1',
            'no_hp' => '00000000000',
            'email' => 'pengembang1@mail.com',
            'password' => Hash::make('password'),
            'created_at' => now()
        ]);

        $roleUmum = Role::where('name', 'Pengembang')->first();

        $userUmum->assignRole([$roleUmum->id]);
        // ========== End Pengembang ==========
    }
}
