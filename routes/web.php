<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::resource('/', DashboardController::class)->names('dashboard');

    Route::get('anggota/data', [AnggotaController::class, 'getData'])->name('anggota.data');
    Route::resource('anggota', AnggotaController::class)->names('anggota');

    Route::get('transaksi/data', [TransaksiController::class, 'getData'])->name('transaksi.data');
    Route::resource('transaksi', TransaksiController::class)->names('transaksi');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
