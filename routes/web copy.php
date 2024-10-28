<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('layout.master');
// });

Route::group(['middleware' => 'guest'], function () {
    //Login
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/loginuser', [LoginController::class, 'loginuser'])->name('proses-login');

    //register
    Route::get('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/registeruser', [LoginController::class, 'registeruser'])->name('register.save');
});

//ini untuk menangkap user login yang mana itu bisa diakses di kedus role
Route::group(['middleware' => 'checkrole: 1,2,3'], function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [RedirectController::class, 'checkRole'])->name('checkRole.redirect');
});

// superadmin route middleware | 1 role saja yaitu superadmin
Route::group(['middleware' => 'checkrole: 1'], function () {
    Route::get('/superadmin', [SuperAdminController::class, 'superadmin'])->name('superadmin.dashboard');
});

// admin route middleware | 1 role saja yaitu admin
Route::group(['middleware' => 'checkrole: 2'], function () {
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin.dashboard');
});

// kasir route middleware | 1 role saja yaitu kasir
Route::group(['middleware' => 'checkrole: 3'], function () {
    Route::get('/kasir', [KasirController::class, 'kasir'])->name('kasir.dashboard');
});


// route DataUser
Route::get('/data-user', [UserController::class, 'index'])->name('data.user');


// kategori
Route::resource('kategori', KategoriController::class);
Route::get('/data-kategori', [KategoriController::class, 'index'])->name('data.kategori');


// produk


// transaksi


// laporan