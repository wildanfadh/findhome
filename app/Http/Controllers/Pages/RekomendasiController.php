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
        $data = [];
        return view('app.uji.rekomendasi', $data);
    }

    public function rekomendasi_preferensi()
    {
        $data = [];
        return view('app.uji.rekomendasi_preferensi', $data);
    }
}
