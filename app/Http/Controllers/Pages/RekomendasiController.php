<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    public function rekomendasi()
    {
        $data = [];
        return view('app.rekomendasi', $data);
    }

    public function preference()
    {
        $data = [];
        return view('app.preference', $data);
    }
}
