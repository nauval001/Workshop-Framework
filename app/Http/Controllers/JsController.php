<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsController extends Controller
{
    public function htmlTable()
    {
        return view('js.html_table');
    }

    public function dataTables()
    {
        return view('js.datatables');
    }

    public function select()
    {
        return view('js.select');
    }
}