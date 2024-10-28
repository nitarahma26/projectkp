<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }

    public function loginuser(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

            // buat ulang session login
            $request->session()->regenerate();

            $role_id = auth()->user()->role_id;

            if ($role_id === 1) {
                // Jika user adalah superadmin
                return redirect()->intended('/superadmin');
            } elseif ($role_id === 2) {
                // Jika user adalah admin
                return redirect()->intended('/admin');
            } elseif ($role_id === 3) {
                // Jika user adalah kasir
                return redirect()->intended('/kasir');
            } else {
                // Jika user memiliki role lain yang tidak dikenali
                return redirect()->intended('/');
            }
        }

        // jika email atau password salah
        // kirimkan session error
        return back()->with('error', 'Email atau Password yang anda masukkan salah');
    }

    public function register(Request $request)
    {
        $role = Role::all();
        return view('Auth.register', ['role' => $role]);
    }

    public function registeruser(Request $request)
    {
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(60),
            'role_id' => $request->role_id,
        ]);

        return redirect('/')
            ->with('success', 'Register Berhasil');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
