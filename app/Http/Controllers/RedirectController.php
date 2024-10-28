<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function checkRole()
    {
        if (Auth::user()->role_id === 1) {
            // Jika user adalah Superadmin
            return redirect()->route('superadmin.dashboard');
        }

        if (Auth::user()->role_id === 2) {
            // Jika user adalah Admin
            return redirect()->route('admin.dashboard');
        }

        if (Auth::user()->role_id === 3) {
            // Jika user adalah Kasir
            return redirect()->route('kasir.dashboard');
        }

        // Jika tidak ada peran yang sesuai
        abort(404);
    }
}
