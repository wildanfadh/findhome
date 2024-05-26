<?php

namespace Database\Seeders;

use App\Models\Pengembang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengembangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 3,
                'alamat' => 'Mojokerto',
                'is_verified' => true,
                'created_at' => now(),
            ],
        ];

        Pengembang::insert($data);
    }
}
