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
        $hs = head_source(['DATATABLESBS5', 'SWEETALERT2', 'SELECT2', 'SELECT2BS4']);
        $js = script_source(['DATATABLES', 'DATATABLESBS5', 'SWEETALERT2', 'BLOCKUI', 'SELECT2']);
        $perumahan = Perumahan::find($id);
        $kriteria = Kriteria::all();
        // dd($kriteria, $perumahan->kriteriaPerumahan->count());

        $data_kriteria = [];
        // if ($perumahan->kriteriaPerumahan->count() > 0) {
        foreach ($kriteria as $k) {
            $data_kriteria[] = [
                'id' => $k->id,
                'nama' => $k->nama,
                'sifat' => $k->sifat,
                'bobot' => $k->bobot,
                'sub_kriteria_id' => $perumahan->kriteriaPerumahan()->where('kriteria_id', $k->id)->first()->sub_kriteria_id,
            ];
        }
        // } else {
        //     $data_kriteria = $kriteria;
        // }
        // dd($data_kriteria, collect($data_kriteria));
        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
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
