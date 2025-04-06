<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Kandang\KandangIndex;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\AyamController;
use App\Http\Controllers\TelurController;
use App\Http\Controllers\KaryawanController;
use App\Livewire\Karyawan\CreateKaryawan;
use App\Livewire\Karyawan\EditKaryawan;
use App\Livewire\Kandang\CreateKandang;
use App\Livewire\Kandang\EditKandang;
use App\Livewire\Ayam\CreateAyam;
use App\Livewire\Ayam\EditAyam;
use App\Livewire\Telur\CreateTelur;
use App\Livewire\Telur\EditTelur;

Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard')->middleware(['auth']);

Route::middleware(['auth', 'not.admin'])->group(function () {
    Route::get('/kandang', [KandangController::class, 'index'])->name('kandang');
    Route::get('/kandang/create', CreateKandang::class)->name('kandang.create');
    Route::get('/kandang/{id}/edit', EditKandang::class)->name('kandang.edit');
    Route::delete('/kandang/{id}/delete',[KandangController::class, 'destroy'])->name('kandang.destroy');

    Route::get('/ayam', [AyamController::class, 'index'])->name('ayam');
    Route::get('/ayam/create', CreateAyam::class)->name('ayam.create');
    Route::get('/ayam/{id}/edit', EditAyam::class)->name('ayam.edit');
    Route::delete('/ayam/{id}/delete',[AyamController::class, 'destroy'])->name('ayam.destroy');

    Route::get('/telur', [TelurController::class, 'index'])->name('telur');
    Route::get('/telur/create', CreateTelur::class)->name('telur.create');
    Route::get('/telur/{id}/edit', EditTelur::class)->name('telur.edit');
    Route::delete('/telur/{id}/delete',[TelurController::class, 'destroy'])->name('telur.destroy');
});

Route::view('profile', 'profile')
->middleware(['auth'])
->name('profile');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
    Route::delete('/karyawan/{id}/delete', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    Route::get('/karyawan/create', CreateKaryawan::class)->name('karyawan.create');
    Route::get('/karyawan/{id}/edit', EditKaryawan::class)->name('karyawan.edit');
});

require __DIR__.'/auth.php';
