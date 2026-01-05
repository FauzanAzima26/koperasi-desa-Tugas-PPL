<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::resource('/', DashboardController::class)->names('dashboard');

    Route::get('anggota/data', [AnggotaController::class, 'getData'])->name('anggota.data');
    Route::resource('anggota', AnggotaController::class)->names('anggota');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
