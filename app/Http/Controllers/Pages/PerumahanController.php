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
        $hs = head_source([]);
        $js = script_source(['BLOCKUI']);
        $perumahan = Perumahan::where('is_verified', 1)->get();

        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            'perumahan' => $perumahan,
        ];
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
        $hs = head_source(['DATATABLESBS5', 'SWEETALERT2', 'SELECT2', 'SELECT2BS4']);
        $js = script_source(['DATATABLES', 'DATATABLESBS5', 'SWEETALERT2', 'BLOCKUI', 'SELECT2']);
        $perumahan = Perumahan::find($id);
        $kriteria = Kriteria::all();

        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            'data' => $perumahan,
            'kriteria' => $kriteria,
            'kriteriaPerumahan' => $perumahan->kriteriaPerumahan
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
