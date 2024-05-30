<?php

namespace Database\Seeders;

use App\Models\Perumahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerumahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode' => 'A1',
                'pengembang_id' => 1,
                'nama' => 'Graha Bhineka Central',
                'alamat' => 'Sidonganti, Ngingasrembyong, Kec. Sooko, Kabupaten Mojokerto, Jawa Timur 61361',
                'keterangan' => null,
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'kode' => 'A2',
                'pengembang_id' => 2,
                'nama' => 'Grand Kencana Mojokerto',
                'alamat' => 'Jalan Kemakmuran, Desa Kedung Maling, Kec. Sooko',
                'keterangan' => null,
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'kode' => 'A3',
                'pengembang_id' => 3,
                'nama' => 'Griya Puri Asri',
                'alamat' => 'Jl. Raya Puri, Griya Puri Asri, Puri, Kec. Puri',
                'keterangan' => null,
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'kode' => 'A4',
                'pengembang_id' => 4,
                'nama' => 'Griya Madureso Asri',
                'alamat' => 'JL, Sawah, Madureso, Kec. Dawar Blandong',
                'keterangan' => null,
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'kode' => 'A5',
                'pengembang_id' => 5,
                'nama' => 'Griya Modopuro Perkasa',
                'alamat' => 'Bangsri, Modopuro, Kec. Mojosari',
                'keterangan' => null,
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'kode' => 'A6',
                'pengembang_id' => 6,
                'nama' => 'Bumi Mojopahit Asri',
                'alamat' => 'Ds. Ngastemi Bangsal',
                'keterangan' => null,
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'kode' => 'A7',
                'pengembang_id' => 7,
                'nama' => 'Garden Icon',
                'alamat' => 'Jl Raya Kebonagung, Kali Putih, Kebonagung, Kec. Puri',
                'keterangan' => null,
                'is_verified' => false,
                'created_at' => now(),
            ],
            [
                'kode' => 'A8',
                'pengembang_id' => 8,
                'nama' => 'Permata Pesanggrahan',
                'alamat' => 'Pesanggrahan, Kutorejo',
                'keterangan' => null,
                'is_verified' => false,
                'created_at' => now(),
            ],
        ];

        Perumahan::insert($data);
    }
}
