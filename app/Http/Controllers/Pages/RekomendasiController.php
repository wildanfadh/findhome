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

        // $loginRole = auth()->user()->roles[0]->name;
        $hasilUji = [];
        if (auth()->user()->roles[0]->name == 'Umum' && isset(auth()->user()->preferencys)) {
            $data_bobot_pref = [];
            foreach (auth()->user()->preferencys as $key => $value) {
                $data_bobot_pref[$value->kriteria_kode] = $value;
            }
            $hasilUji = $this->uji_topsis_preference($data_bobot_pref);
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

    public function rekomendasi_preferensi()
    {
        $hs = head_source(['SWEETALERT2', 'SELECT2', 'SELECT2BS4']);
        $js = script_source(['SWEETALERT2', 'BLOCKUI', 'SELECT2']);
        // $hasilUji = $this->uji_topsis_preference();
        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            // "hasilUji" => $hasilUji
        ];
        return view('app.uji.rekomendasi_preferensi', $data);
    }
}
