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

        $data_pengembang = [
            [
                'name' => 'Pengembang 1 (Test)',
                'username' => 'pengembang1',
                'no_hp' => '00000000000',
                'email' => 'pengembang1@mail.com',
                'password' => Hash::make('password'),
                'created_at' => now()
            ],
            [
                'name' => 'Pengembang 2 (Test)',
                'username' => 'pengembang2',
                'no_hp' => '00000000000',
                'email' => 'pengembang2@mail.com',
                'password' => Hash::make('password'),
                'created_at' => now()
            ],
            [
                'name' => 'Pengembang 3 (Test)',
                'username' => 'pengembang3',
                'no_hp' => '00000000000',
                'email' => 'pengembang3@mail.com',
                'password' => Hash::make('password'),
                'created_at' => now()
            ],
            [
                'name' => 'Pengembang 4 (Test)',
                'username' => 'pengembang4',
                'no_hp' => '00000000000',
                'email' => 'pengembang4@mail.com',
                'password' => Hash::make('password'),
                'created_at' => now()
            ],
            [
                'name' => 'Pengembang 5 (Test)',
                'username' => 'pengembang5',
                'no_hp' => '00000000000',
                'email' => 'pengembang5@mail.com',
                'password' => Hash::make('password'),
                'created_at' => now()
            ],
            [
                'name' => 'Pengembang 6 (Test)',
                'username' => 'pengembang6',
                'no_hp' => '00000000000',
                'email' => 'pengembang6@mail.com',
                'password' => Hash::make('password'),
                'created_at' => now()
            ],
            [
                'name' => 'Pengembang 7 (Test)',
                'username' => 'pengembang7',
                'no_hp' => '00000000000',
                'email' => 'pengembang7@mail.com',
                'password' => Hash::make('password'),
                'created_at' => now()
            ],
            [
                'name' => 'Pengembang 8 (Test)',
                'username' => 'pengembang8',
                'no_hp' => '00000000000',
                'email' => 'pengembang8@mail.com',
                'password' => Hash::make('password'),
                'created_at' => now()
            ],
        ];

        foreach ($data_pengembang as $key => $value) {
            $userPengembang = User::create($value);

            $rolePengembang = Role::where('name', 'Pengembang')->first();

            $userPengembang->assignRole([$rolePengembang->id]);
        }
        // ========== End Pengembang ==========
    }
}
