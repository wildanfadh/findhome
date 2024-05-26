<?php

namespace App\Http\Controllers\Pages;

use App\Models\Kriteria;
use App\Models\Perumahan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PerumahanRequest;

class PerumahanController extends Controller
{
    public function list_perumahan()
    {
        $data = [];
        return view('app.perumahan.list', $data);
    }

    public function proyek_perumahan()
    {
        $hs = head_source(['DATATABLESBS5', 'SWEETALERT2']);
        $js = script_source(['DATATABLES', 'DATATABLESBS5', 'SWEETALERT2', 'BLOCKUI']);

        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
        ];
        return view('app.perumahan.proyek', $data);
    }

    public function detail_perumahan($id)
    {
        $perumahan = Perumahan::find($id);
        $kriteria = Kriteria::all();
        $data = [
            'data' => $perumahan,
            'kriteria' => $kriteria,
        ];
        return view('app.perumahan.detail', $data);
    }

    // public function detail_perumahan_kriteria($id)
    // {
    //     $perumahan = Perumahan::find($id);
    //     $kriteria = Kriteria::all();
    //     $data = [
    //         'data' => $perumahan,
    //         'kriteria' => $kriteria,
    //     ];
    //     return view('app.perumahan.detail_kriteria', $data);
    // }
}
