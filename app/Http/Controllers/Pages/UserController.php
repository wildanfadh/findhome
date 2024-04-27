<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register_pengembang()
    {
        return view('auth.register_pengembang');
    }
}
