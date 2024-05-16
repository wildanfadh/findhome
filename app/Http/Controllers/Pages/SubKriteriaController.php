<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $hs = head_source(['DATATABLESBS5', 'SWEETALERT2']);
        $js = script_source(['DATATABLES', 'DATATABLESBS5', 'SWEETALERT2', 'BLOCKUI']);

        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
        ];

        return view('app.master.subkriteria', $data);
    }

    public function list_by_kriteria($id)
    {
        $hs = head_source(['DATATABLESBS5', 'SWEETALERT2']);
        $js = script_source(['DATATABLES', 'DATATABLESBS5', 'SWEETALERT2', 'BLOCKUI']);

        $kriteria = Kriteria::find($id);
        // dd($kriteria);

        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            "data" => $kriteria
        ];

        return view('app.master.subkriteria', $data);
    }
}
