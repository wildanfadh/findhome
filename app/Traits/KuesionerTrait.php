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

        // Mencari Baris Total

        // Menormalisasikan matriks & bobot prioritas

        // Mencari Konsistensi Matriks

        // Berikutnya mencari CI (Consistency Index)

        // Berikutnya mencari RI (Ratio Index)
    }
}
