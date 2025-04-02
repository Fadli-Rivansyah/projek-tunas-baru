<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Kandang\KandangIndex;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\KaryawanController;
use App\Livewire\Karyawan\CreateKaryawan;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/kandang', [KandangController::class, 'index'])->name('kandang');
Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');

Route::get('/karyawan/create', CreateKaryawan::class)->name('create-karyawan');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
