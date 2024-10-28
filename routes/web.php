<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Auth\Events\Login;
use App\Http\Controllers\GuestController;
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
    // Login
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/loginuser', [LoginController::class, 'loginuser'])->name('proses-login');
    Route::get('/guest', [GuestController::class, 'index']);

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
    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);
});

// admin route middleware | 1 role saja yaitu admin
Route::group(['middleware' => 'checkrole: 2'], function () {
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin.dashboard');
    Route::resource('data-user', UserController::class);
});

// kasir route middleware | 1 role saja yaitu kasir
Route::group(['middleware' => 'checkrole: 3'], function () {
    Route::get('/kasir', [KasirController::class, 'kasir'])->name('kasir.dashboard');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
});


// route DataUser
Route::get('/data-user', [UserController::class, 'index'])->name('data.user');
Route::get('/datauser/{id}/edit', [UserController::class, 'edit'])->name('datauser.edit');
Route::put('/datauser/{id}', [UserController::class, 'update'])->name('datauser.update');
Route::delete('/datauser/{id}', [UserController::class, 'destroy'])->name('datauser.destroy');



// kategori
Route::resource('kategori', KategoriController::class);
Route::get('/data-kategori', [KategoriController::class, 'index'])->name('data.kategori');


// produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::resource('produk', ProdukController::class)->middleware('checkrole:1');
Route::prefix('DataMaster')->group(function () {
    Route::resource('produk', ProdukController::class);
});
Route::get('/produk/tambah-stok', [ProdukController::class, 'tambahStok'])->name('produk.tambah-stok');
Route::post('/produk/update-stok/{id}', [ProdukController::class, 'updateStok'])->name('produk.update-stok');


// transaksi


// laporan
