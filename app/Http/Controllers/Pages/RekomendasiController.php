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

    public function rekomendasi()
    {
        $hs = head_source(['SWEETALERT2', 'SELECT2', 'SELECT2BS4']);
        $js = script_source(['SWEETALERT2', 'BLOCKUI', 'SELECT2']);
        $hasilUjiUmum = $this->uji_topsis_general();
        $hasilUjiPreference = $this->uji_topsis_preference();

        $loginRole = auth()->user()->roles[0]->name;
        $hasilUji = [];
        if ($loginRole == 'Umum') {
            $hasilUji = $hasilUjiPreference;
        } else {
            $hasilUji = $hasilUjiUmum;
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

    public function rekomendasi_preferensi()
    {
        $hs = head_source(['SWEETALERT2', 'SELECT2', 'SELECT2BS4']);
        $js = script_source(['SWEETALERT2', 'BLOCKUI', 'SELECT2']);
        $hasilUji = $this->uji_topsis_preference();
        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            "hasilUji" => $hasilUji
        ];
        return view('app.uji.rekomendasi_preferensi', $data);
    }
}
