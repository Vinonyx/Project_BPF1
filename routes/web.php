<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;

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

//Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/chart-barang-masuk', [DashboardController::class, 'barang_masuk'])->name('chart-barang-masuk');

//List Barang
Route::get('/list', [BarangController::class, 'index'])->name('list');
Route::post('/list/store', [BarangController::class, 'store'])->name('list.store');
Route::get('/list/destroy/{id}', [BarangController::class, 'destroy'])->name('list.destroy');
Route::post('/list/update/{id}', [BarangController::class, 'update'])->name('list.edit');

//Barang Masuk
Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk');
Route::post('/barang-masuk/store/{id}', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
Route::get('/history-barang-masuk', [BarangMasukController::class, 'history'])->name('history-barang-masuk');

//Barang Keluar
Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar');
Route::post('/barang-keluar/store/{id}', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
Route::get('/history-barang-keluar', [BarangKeluarController::class, 'history'])->name('history-barang-keluar');

// Barang haram
Route::get('/api', [BarangController::class, 'barangMasuk'])->name('api');
