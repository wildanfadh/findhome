<?php

namespace Database\Seeders;

use App\Enums\SifatKriteria;
use App\Models\Kriteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Harga',
                'sifat' => SifatKriteria::COST,
                'bobot' => 0.19,
                'created_at' => now(),
            ],
            [
                'nama' => 'Tipe',
                'sifat' => SifatKriteria::BENEFIT,
                'bobot' => 0.20,
                'created_at' => now(),
            ],
            [
                'nama' => 'Fasilitas Umum',
                'sifat' => SifatKriteria::BENEFIT,
                'bobot' => 0.28,
                'created_at' => now(),
            ],
            [
                'nama' => 'Lokasi',
                'sifat' => SifatKriteria::BENEFIT,
                'bobot' => 0.33,
                'created_at' => now(),
            ],
        ];

        Kriteria::insert($data);
    }
}
