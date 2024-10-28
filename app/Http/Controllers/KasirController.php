<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function kasir()
    {
        return view('Kasir.index');
    }
}
