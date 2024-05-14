<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $hs = head_source(['DATATABLESBS5']);
        $js = script_source(['DATATABLES', 'DATATABLESBS5']);

        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
        ];

        return view('app.master.kriteria', $data);
    }
}
