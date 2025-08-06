<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ReportController;

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

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Kategori routes
Route::resource('kategoris', KategoriController::class);

// COA routes
Route::resource('coas', CoaController::class);

// Transaksi routes
Route::resource('transaksis', TransaksiController::class);

// Report routes
Route::get('/reports/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit-loss');
Route::get('/reports/profit-loss/export', [ReportController::class, 'exportProfitLoss'])->name('reports.export-profit-loss');
