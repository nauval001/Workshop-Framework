<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function wilayah()
    {
        return view('ajax.wilayah');
    }
}