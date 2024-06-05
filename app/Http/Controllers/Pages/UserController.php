<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
        return view('app.pengguna.index', $data);
    }

    // public function pengembang()
    // {
    //     $hs = head_source(['DATATABLESBS5', 'SWEETALERT2']);
    //     $js = script_source(['DATATABLES', 'DATATABLESBS5', 'SWEETALERT2', 'BLOCKUI']);

    //     $user = User::all();
    //     $data = [
    //         'user' => $user,
    //         "HeadSource" => $hs,
    //         "JsSource" => $js,
    //     ];
    //     return view('app.pengguna.pengembang', $data);
    // }

    public function register_pengembang()
    {
        $hs = head_source(['DATATABLESBS5', 'SWEETALERT2']);
        $js = script_source(['DATATABLES', 'DATATABLESBS5', 'SWEETALERT2', 'BLOCKUI']);
        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
        ];
        return view('auth.register_pengembang', $data);
    }

    public function myprofile()
    {
        $hs = head_source(['SWEETALERT2']);
        $js = script_source(['SWEETALERT2', 'BLOCKUI']);
        $user = User::find(auth()->user()->id);
        $data = [
            "HeadSource" => $hs,
            "JsSource" => $js,
            'user' => $user,
        ];
        return view('app.settings.myprofile', $data);
    }
}
