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
                'nama_perusahaan' => "PT. PERSADA BHINNEKA TIMUR",
                'alamat' => 'Mojokerto',
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'user_id' => 4,
                'nama_perusahaan' => "PT. BANGUN GRIYA INSANI SEJAHTERA",
                'alamat' => 'Mojokerto',
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'user_id' => 5,
                'nama_perusahaan' => "PT. SEJAHTERA BERSAMA",
                'alamat' => 'Mojokerto',
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'user_id' => 6,
                'nama_perusahaan' => "PT. JOKAM GRIYA BAROKAH",
                'alamat' => 'Mojokerto',
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'user_id' => 7,
                'nama_perusahaan' => "PT. PERSADA BANGUN PERKASA",
                'alamat' => 'Mojokerto',
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'user_id' => 8,
                'nama_perusahaan' => "PT. TIA CAHYA GRIYA",
                'alamat' => 'Mojokerto',
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'user_id' => 9,
                'nama_perusahaan' => "PT. CIPTA ADI PERKASA",
                'alamat' => 'Mojokerto',
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'user_id' => 10,
                'nama_perusahaan' => "PT. GRAHA RUBY KASTARA",
                'alamat' => 'Mojokerto',
                'is_verified' => false,
                'created_at' => now(),
            ],
        ];

        Pengembang::insert($data);
    }
}
