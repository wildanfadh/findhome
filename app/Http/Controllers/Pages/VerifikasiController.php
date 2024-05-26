<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pengembang;
use App\Models\Perumahan;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        $hs = head_source(['DATATABLESBS5', 'SWEETALERT2']);
        $js = script_source(['DATATABLES', 'DATATABLESBS5', 'SWEETALERT2', 'BLOCKUI']);
        $pengembang = Pengembang::where('is_verified', 0)->get();
        $perumahan = Perumahan::where('is_verified', 0)->get();
        // dd($pengembang);
        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            "pengembang" => $pengembang,
            "perumahan" => $perumahan,
        ];
        return view('app.verifikasi.index', $data);
    }
}
