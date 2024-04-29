<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        return view('app.master.subkriteria');
    }
}
