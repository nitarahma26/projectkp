<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua pengguna dari database
        $users = DB::table('users')->get();

        // Mengembalikan tampilan dengan data pengguna
        return view('datauser.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validasi data
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
        ]);

        // Menyimpan data pengguna baru
        User::create($request->all());

        return redirect()->route('datauser.index')->with('success', 'User  created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Mengambil pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Menampilkan form edit
        return view('datauser.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
        ]);

        // Mengambil pengguna berdasarkan ID
        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('datauser.index')->with('success', 'User  updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Menghapus pengguna berdasarkan ID
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('datauser.index')->with('success', 'User  deleted successfully.');
    }
}
