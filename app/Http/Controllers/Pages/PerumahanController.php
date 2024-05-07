<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerumahanRequest;
use App\Models\Perumahan;
use Illuminate\Http\Request;

class PerumahanController extends Controller
{
    public function list_perumahan()
    {
        $data = [];
        return view('app.perumahan.list', $data);
    }

    public function detail_perumahan($id)
    {
        $perumahan = Perumahan::find($id);
        $data = ['data' => $perumahan];
        return view('app.perumahan.detail', $data);
    }
}
