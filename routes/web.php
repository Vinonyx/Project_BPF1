<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CartController;
use App\Models\Transaksi;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/profile/editNama/{id}', [DashboardController::class, 'editNama'])->name('profile.editNama');
Route::post('/profile/editEmail/{id}', [DashboardController::class, 'editEmail'])->name('profile.editEmail');
Route::post('/user/store', [DashboardController::class, 'store'])->name('user.store');
Route::get('/user/destroy/{id}', [DashboardController::class, 'destroyUser'])->name('user.destroy');

// List Barang
Route::get('/list', [BarangController::class, 'index'])->name('list');
Route::post('/list/store', [BarangController::class, 'store'])->name('list.store');
Route::get('/mark-as-read', [BarangController::class, 'markAsRead'])->name('markAsRead');
Route::get('/list/destroy/{id}', [BarangController::class, 'destroy'])->name('list.destroy');
Route::post('/list/update/{id}', [BarangController::class, 'update'])->name('list.edit');

// Barang Masuk
Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk');
Route::post('/barang-masuk/store/{nama}', [BarangMasukController::class, 'store'])->name('barang-masuk.store');

// Transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');

// Barang Keluar
Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar');
Route::post('/barang-keluar/store/{nama}', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');

// Fetch Data
Route::get('/chart-barang_masuk', [DashboardController::class, 'barang_masuk'])->name('chart.barang_masuk');
Route::get('/chart-barang_keluar', [DashboardController::class, 'barang_keluar'])->name('chart.barang_keluar');
Route::get('/getSatuan', [BarangMasukController::class, 'getSatuan'])->name('barang-masuk.satuan');

// Cart
Route::post('/addToCart', [CartController::class, 'store'])->name('cart.store');
