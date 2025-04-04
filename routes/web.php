<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Kandang\KandangIndex;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\KaryawanController;
use App\Livewire\Karyawan\CreateKaryawan;
use App\Livewire\Kandang\CreateKandang;

Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard')->middleware(['auth']);

Route::middleware(['auth', 'not.admin'])->group(function () {
    Route::get('/kandang', [KandangController::class, 'index'])->name('kandang');
    Route::get('/kandang/create', CreateKandang::class)->name('kandang.create');
});

Route::view('profile', 'profile')
->middleware(['auth'])
->name('profile');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
    Route::get('/karyawan/create', CreateKaryawan::class)->name('karyawan.create');
});

require __DIR__.'/auth.php';
