<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
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
        $hasilUji = $this->uji_topsis_general();
        dd($hasilUji);
        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
        ];
        return view('app.uji.rekomendasi', $data);
    }

    public function rekomendasi_preferensi()
    {
        $data = [];
        return view('app.uji.rekomendasi_preferensi', $data);
    }
}
