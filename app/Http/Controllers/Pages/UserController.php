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

    public function pengembang()
    {
        $user = User::all();
        $data = [
            'user' => $user,
        ];
        return view('app.pengguna.pengembang', $data);
    }

    public function register_pengembang()
    {
        return view('auth.register_pengembang');
    }

    public function myprofile()
    {
        $user = User::find(auth()->user->id);
        $data = [
            'user' => $user,
        ];
        return view('app.settings.myprofile', $data);
    }
}
