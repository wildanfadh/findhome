<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
