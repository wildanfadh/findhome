<?php

namespace App\Http\Controllers\Pages;

use App\Models\Perumahan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hs = head_source(['SWEETALERT2', 'SELECT2', 'SELECT2BS4']);
        $js = script_source(['SWEETALERT2', 'BLOCKUI', 'SELECT2']);

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

        // data perumahan terkini
        $perumahan_terkini = Perumahan::where('is_verified', 1)->latest()->get();
        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            "hasilUji" => $hasilUji,
            "perumahan_terkini" => $perumahan_terkini
        ];
        return view('app.beranda', $data);
    }
}
