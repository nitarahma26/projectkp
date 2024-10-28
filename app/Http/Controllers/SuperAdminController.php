<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function superadmin()
    {
        return view('SuperAdmin.index');
    }
}
