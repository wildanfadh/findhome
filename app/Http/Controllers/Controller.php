<?php

namespace App\Http\Controllers;

use App\Traits\AjaxResponserTrait;
use App\Traits\UjiTopsisDirectTrait;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, AjaxResponserTrait, UjiTopsisDirectTrait;
}
