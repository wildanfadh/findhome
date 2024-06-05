<?php

namespace App\Http\Controllers\Pages;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengembang;

class PengembangController extends Controller
{
    public function index()
    {
        $hs = head_source(['DATATABLESBS5', 'SWEETALERT2']);
        $js = script_source(['DATATABLES', 'DATATABLESBS5', 'SWEETALERT2', 'BLOCKUI']);

        $user = User::all();
        $data = [
            'user' => $user,
            "HeadSource" => $hs,
            "JsSource" => $js,
        ];
        return view('app.pengembang.index', $data);
    }

    public function detail_pengembang($id)
    {
        $hs = head_source(['SWEETALERT2']);
        $js = script_source(['SWEETALERT2', 'BLOCKUI']);
        $pengembang = Pengembang::find($id);
        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            'pengembang' => $pengembang,
        ];
        return view('app.pengembang.detail', $data);
    }
}
