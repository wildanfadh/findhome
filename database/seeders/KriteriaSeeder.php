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
                'kode' => 'K1',
                'nama' => 'Harga',
                'sifat' => SifatKriteria::COST,
                'bobot' => 0.19,
                'keterangan' => 'Harga rumah merupakan jumlah tagihan uang yang perlu dibayarkan oleh pembeli rumah kepada penjual rumah.',
                'created_at' => now(),
            ],
            [
                'kode' => 'K2',
                'nama' => 'Tipe',
                'sifat' => SifatKriteria::BENEFIT,
                'bobot' => 0.20,
                'keterangan' => 'Tipe merupakan luasan lantai bangunan dari suatu unit rumah.',
                'created_at' => now(),
            ],
            [
                'kode' => 'K3',
                'nama' => 'Fasilitas Umum',
                'sifat' => SifatKriteria::BENEFIT,
                'bobot' => 0.28,
                'keterangan' => 'Fasilitas umum perumahan merupakan sarana prasarana yang disediakan oleh pengembang untuk kepentingan umum.',
                'created_at' => now(),
            ],
            [
                'kode' => 'K4',
                'nama' => 'Lokasi',
                'sifat' => SifatKriteria::BENEFIT,
                'bobot' => 0.33,
                'keterangan' => 'Lokasi Strategis rumah yang dapat dilihat dari berbagai aspek seperti aksesibilitas menuju lokasi rumah, jarak terhadap fasilitas umum (trasnportasi, kesehatan, perdagangan, perkantoran, pendidikan, hiburan dan lain-lain)',
                'created_at' => now(),
            ],
        ];

        Kriteria::insert($data);
    }
}
