<?php

namespace App\Traits;

use App\Models\Kriteria;

trait KuesionerTrait
{

    public function generate_kuesioner()
    {
        $kriterias = Kriteria::all();
        $kuesioners = [];
        foreach ($kriterias as $key => $kriteria) {
            $kuesioners[$key] = [$kriteria->kode];
        }

        $all_kuesioners = [];
        for ($i = 0; $i < count($kuesioners); $i++) {
            // // dd($kuesioners[$i]);
            // $kri1 = [];
            for ($i1 = 0; $i1 < count($kuesioners); $i1++) {
                if (isset($kuesioners[$i1 + 1])) {
                    array_push($all_kuesioners, [$kuesioners[$i][0], $kuesioners[$i1 + 1][0]]);
                }
            }
        }
        // dd($all_kuesioners);

        $kuesioner_texts = [];
        foreach ($all_kuesioners as $key => $kuesioner) {
            if ($kuesioner[0] == $kuesioner[1]) {
                continue;
            }
            // dd($kuesioner);
            $data1 = Kriteria::where('kode', $kuesioner[0])->first();
            $data2 = Kriteria::where('kode', $kuesioner[1])->first();

            if ($data1->id > $data2->id) {
                continue;
            }

            $kuesioner_texts[$key] = [
                'kode' => "$data1->kode" . "_" . "$data2->kode",
                'pertanyaan' => "Bagaimanakah perbandingan antara $data1->nama ($data1->kode) dengan $data2->nama ($data2->kode) sebagai kriteria pendukung keputusan pemilihan perumahan subsidi?",
                'pilihans' => [
                    '1' => "$data1->kode dan $data2->kode sama penting",
                    '2' => "$data1->kode sedikit lebih penting dari $data2->kode",
                    '3' => "$data1->kode lebih penting dari $data2->kode",
                    '4' => "$data1->kode sangat penting dari $data2->kode",
                    '5' => "$data1->kode mutlak pentingnya dari $data2->kode",
                    '6' => "$data2->kode sedikit lebih penting dari $data1->kode",
                    '7' => "$data2->kode lebih penting dari $data1->kode",
                    '8' => "$data2->kode sangat penting dari $data1->kode",
                    '9' => "$data2->kode mutlak pentingnya dari $data1->kode",
                ],
            ];
        }
        // dd($kuesioner_texts);

        return $kuesioner_texts;
    }


    public function hitung_bobot($data_preferensi)
    {
        // Hitung Bobot Menggunakan Metode AHP (Analytic hierarchy process)
        // dd($data_preferensi);
        // Contoh Parameter
        // array:6 [
        //     "K1_K2" => "2"
        //     "K1_K3" => "3"
        //     "K1_K4" => "1"
        //     "K2_K3" => "3"
        //     "K2_K4" => "3"
        //     "K3_K4" => "4"
        //   ]

        // Inisialisasi matriks preferensi dengan nilai default 1
        $matriks_preferensi = [];
        $jumlah_kriteria = count($data_preferensi) / 2; // Hitung jumlah kriteria berdasarkan jumlah pasangan kriteria yang diberikan
        for ($i = 1; $i <= $jumlah_kriteria; $i++) {
            for ($j = 1; $j <= $jumlah_kriteria; $j++) {
                $matriks_preferensi["K{$i}_K{$j}"] = $data_preferensi["K{$i}_K{$j}"] ?? 1;
            }
        }

        // Hitung Baris Total
        $baris_total = [];
        foreach ($matriks_preferensi as $key => $value) {
            $baris = explode("_", $key)[0];
            if (!isset($baris_total[$baris])) {
                $baris_total[$baris] = 0;
            }
            $baris_total[$baris] += $value;
        }

        // Normalisasi Matriks & Bobot Prioritas
        $matriks_normalisasi = [];
        foreach ($matriks_preferensi as $key => $value) {
            $baris = explode("_", $key)[0];
            $kolom = explode("_", $key)[1];
            $matriks_normalisasi[$key] = $value / $baris_total[$kolom];
        }
        // dd($matriks_normalisasi);

        $bobot_prioritas = [];
        $jumlah_kriteria = count($baris_total);
        for ($i = 1; $i <= $jumlah_kriteria; $i++) {
            $total_kolom = 0;
            for ($j = 1; $j <= $jumlah_kriteria; $j++) {
                $total_kolom += $matriks_normalisasi["K{$i}_K{$j}"];
            }
            $bobot_prioritas["K{$i}"] = $total_kolom / $jumlah_kriteria;
        }

        // Hitung bobot prioritas dengan membulatkan ke dua angka desimal
        foreach ($bobot_prioritas as $key => $value) {
            $bobot_prioritas[$key] = round($value, 2);
        }

        $data_kriteria = Kriteria::all();
        $bobot = [];
        foreach ($data_kriteria as $krikey => $krivalue) {
            $bobot[$krivalue->kode] = $bobot_prioritas[$krivalue->kode] ?? 0;
        }
        // dd($bobot);

        // dd($bobot_prioritas);
        // Mencari Konsistensi Matriks
        $eigen = 0;
        foreach ($bobot as $bot) {
            $eigen += $bot;
        }

        $lambda_max = $eigen / $jumlah_kriteria;

        $ci = ($lambda_max - $jumlah_kriteria) / ($jumlah_kriteria - 1);

        // Nilai Random Index (RI) biasanya sudah tersedia dalam tabel referensi
        $ri = 0.90; // Misalnya, untuk matriks 4x4

        $cr = $ci / $ri;
        // dd($cr < $ri);

        $result = [
            'konsisten' => $cr < $ri,
            'bobot' => $bobot,
        ];

        return $result;
    }
}
