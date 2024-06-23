<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{

    public function preferensi()
    {
        $data = [];
        return view('app.preferensi', $data);
    }

    public function perhitungan()
    {
        $hs = head_source(['SWEETALERT2', 'SELECT2', 'SELECT2BS4']);
        $js = script_source(['SWEETALERT2', 'BLOCKUI', 'SELECT2']);

        $kriterias = Kriteria::with(['subKriterias'])->get();

        // menentukan matriks
        $matriks = $this->matrikKeputusan($kriterias);
        // matriks kuadrat
        $matriks_kuadrat = $this->kuadratkanMatrik($matriks);
        // normalisasi
        $matriks_normalisasi = $this->normalisasi($matriks, $matriks_kuadrat);
        // perhitungan bobot
        $normalisasi_bobot = $this->normalisasiTerbobot($matriks_normalisasi);
        // matriks solusi ideal
        $solusi_ideal = $this->matrikSolusiIdeal($normalisasi_bobot);
        // matriks solusi ideal positif
        $solusi_ideal_positif = $this->aPLus($normalisasi_bobot, $solusi_ideal);
        // matriks solusi ideal negatif
        $solusi_ideal_negatif = $this->aMin($normalisasi_bobot, $solusi_ideal);
        // perhitungan jarak
        $jarak = $this->jarakMatrikSolusiIdeal($normalisasi_bobot, $solusi_ideal_positif, $solusi_ideal_negatif);
        // nilai preferenasi
        $preferensi = $this->nilaiPreferensi($jarak);
        // dd($preferensi);


        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            "kriterias" => $kriterias,
            "matriks" => $matriks,
            "matriks_kuadrat" => $matriks_kuadrat,
            "matriks_normalisasi" => $matriks_normalisasi,
            "normalisasi_bobot" => $normalisasi_bobot,
            "solusi_ideal" => $solusi_ideal,
            "solusi_ideal_positif" => $solusi_ideal_positif,
            "solusi_ideal_negatif" => $solusi_ideal_negatif,
            "jarak" => $jarak,
            "preferensi" => $preferensi,
        ];
        return view('app.uji.perhitungan', $data);
    }

    public function perhitungan_preferensi()
    {
        $hs = head_source(['SWEETALERT2', 'SELECT2', 'SELECT2BS4']);
        $js = script_source(['SWEETALERT2', 'BLOCKUI', 'SELECT2']);

        $kriterias = Kriteria::with(['subKriterias'])->get();

        $data_bobot_pref = [];
        if (auth()->user()->roles[0]->name == 'Umum') {
            foreach (auth()->user()->preferencys as $key => $value) {
                $data_bobot_pref[$value->kriteria_kode] = $value;
            }
        }
        // dd($data_bobot_pref);

        // menentukan matriks
        $matriks = $this->matrikKeputusanPr($data_bobot_pref);
        // matriks kuadrat
        $matriks_kuadrat = $this->kuadratkanMatrikPr($matriks);
        // normalisasi
        $matriks_normalisasi = $this->normalisasiPr($matriks, $matriks_kuadrat);
        // perhitungan bobot
        $normalisasi_bobot = $this->normalisasiTerbobotPr($matriks_normalisasi, $data_bobot_pref);
        // matriks solusi ideal
        $solusi_ideal = $this->matrikSolusiIdealPr($normalisasi_bobot);
        // matriks solusi ideal positif
        $solusi_ideal_positif = $this->aPLusPr($normalisasi_bobot, $solusi_ideal);
        // matriks solusi ideal negatif
        $solusi_ideal_negatif = $this->aMinPr($normalisasi_bobot, $solusi_ideal);
        // perhitungan jarak
        $jarak = $this->jarakMatrikSolusiIdealPr($normalisasi_bobot, $solusi_ideal_positif, $solusi_ideal_negatif);
        // nilai preferenasi
        $preferensi = $this->nilaiPreferensiPr($jarak);
        // dd($preferensi);


        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            "kriterias" => $kriterias,
            "matriks" => $matriks,
            "matriks_kuadrat" => $matriks_kuadrat,
            "matriks_normalisasi" => $matriks_normalisasi,
            "normalisasi_bobot" => $normalisasi_bobot,
            "solusi_ideal" => $solusi_ideal,
            "solusi_ideal_positif" => $solusi_ideal_positif,
            "solusi_ideal_negatif" => $solusi_ideal_negatif,
            "jarak" => $jarak,
            "preferensi" => $preferensi,
        ];
        return view('app.uji.perhitungan_preferensi', $data);
    }

    public function rekomendasi()
    {
        $hs = head_source(['SWEETALERT2', 'SELECT2', 'SELECT2BS4']);
        $js = script_source(['SWEETALERT2', 'BLOCKUI', 'SELECT2']);

        // $loginRole = auth()->user()->roles[0]->name;
        $hasilUji = [];
        // if (auth()->user()->roles[0]->name == 'Umum' && auth()->user()->preferencys->count() > 0) {
        if (auth()->user()->roles[0]->name == 'Umum') {
            $data_bobot_pref = [];
            foreach (auth()->user()->preferencys as $key => $value) {
                $data_bobot_pref[$value->kriteria_kode] = $value;
            }
            // dd(count($data_bobot_pref));
            if (count($data_bobot_pref)) {
                $hasilUji = $this->uji_topsis_preference($data_bobot_pref);
            }
        } else {
            $hasilUji = $this->uji_topsis_general();
        }

        $kriterias = Kriteria::all();
        $kuesioners = $this->generate_kuesioner();
        // dd($kuesioners);

        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            "hasilUji" => $hasilUji,
            "kriterias" => $kriterias,
            "kuesioners" => $kuesioners
        ];
        return view('app.uji.rekomendasi', $data);
    }

    // public function rekomendasi_preferensi()
    // {
    //     $hs = head_source(['SWEETALERT2', 'SELECT2', 'SELECT2BS4']);
    //     $js = script_source(['SWEETALERT2', 'BLOCKUI', 'SELECT2']);
    //     // $hasilUji = $this->uji_topsis_preference();
    //     $data = [
    //         "HeadSource" => $hs,
    //         "JsSource" => $js,
    //         // "hasilUji" => $hasilUji
    //     ];
    //     return view('app.uji.rekomendasi_preferensi', $data);
    // }
}
