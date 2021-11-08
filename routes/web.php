<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/makanan', [MenuController::class, 'makanan']);
    Route::get('/minuman', [MenuController::class, 'minuman']);
    Route::post('/keranjang/pesanan/{id}', [PesananController::class, 'keranjangPesananId']);
    Route::get('/keranjang/pesanan', [PesananController::class, 'keranjangPesanan']);    
    Route::get('/pesanan/detail/hapus/{id_pesanan}/{id_menu}', [PesananController::class, 'hapusPesananDetail']);
    Route::post('/pesan/{id}', [PesananController::class, 'pesan']);
    Route::get('/pesanan/masuk', [PesananController::class, 'pesananMasuk']); 
    Route::post('/bayar', [PesananController::class, 'bayar']);   
    Route::get('/hapus/pesanan/{id}', [PesananController::class, 'hapusPesanan']);

    Route::get('/pesanan/keluar', [PesananController::class, 'pesananKeluar']);
    Route::get('/laporan/dibayar', [PesananController::class, 'laporanDibayar']);
    Route::get('/laporan/belumdibayar', [PesananController::class, 'laporanBelumDibayar']);
    Route::get('/cetak/pembayaran/{id}', [PesananController::class, 'cetakPembayaran']);

    Route::get('/searchDibayar', [PesananController::class, 'searchDibayar']);
    Route::get('/searchBelumDibayar', [PesananController::class, 'searchBelumDibayar']);

});
