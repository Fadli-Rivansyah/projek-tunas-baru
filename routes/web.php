<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\KaryawanMain;
use App\Livewire\Karyawan\CreateKaryawan;
use App\Livewire\Karyawan\EditKaryawan;
use App\Livewire\Karyawan\ViewKaryawan;
use App\Livewire\Pages\KandangMain;
use App\Livewire\Kandang\CreateKandang;
use App\Livewire\Kandang\EditKandang;
use App\Livewire\Pages\AyamMain;
use App\Livewire\Ayam\CreateAyam;
use App\Livewire\Ayam\EditAyam;
use App\Livewire\Pages\TelurMain;
use App\Livewire\Telur\CreateTelur;
use App\Livewire\Telur\EditTelur;
use App\Livewire\Pages\PakanMain;
use App\Livewire\Pakan\CreatePakan;
use App\Livewire\pakan\EditPakan;
// use App\Http\Controllers\Report\ReportAyamController;

Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

Route::get('dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard')->middleware(['auth']);
Route::middleware(['auth', 'not.admin'])->group(function () {
    
    Route::get('/kandang', KandangMain::class)->name('kandang');
    Route::get('/kandang/create', CreateKandang::class)->name('kandang.create');
    Route::get('/kandang/{id}/edit', EditKandang::class)->name('kandang.edit');
    Route::get('/kandang/{id}/delete', KandangMain::class)->name('kandang.destroy');

    Route::get('/ayam', AyamMain::class)->name('ayam');
    Route::get('/ayam/create', CreateAyam::class)->name('ayam.create');
    Route::get('/ayam/{id}/edit', EditAyam::class)->name('ayam.edit');
    Route::get('/ayam/{id}/delete', AyamMain::class)->name('ayam.destroy');
    Route::get('/ayam/filter', AyamMain::class)->name('ayam.filter');
    // Route::get('/ayam/{name}/export-pdf', [ReportAyamController::class,'exportPdf'])->name('ayam.export.pdf');


    Route::get('/telur', TelurMain::class)->name('telur');
    Route::get('/telur/create', CreateTelur::class)->name('telur.create');
    Route::get('/telur/{id}/edit', EditTelur::class)->name('telur.edit');
    Route::get('/telur/{id}/delete', TelurMain::class)->name('telur.destroy');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/karyawan', KaryawanMain::class)->name('karyawan');
    Route::get('/karyawan/create', CreateKaryawan::class)->name('karyawan.create');
    Route::get('/karyawan/{id}/edit', EditKaryawan::class)->name('karyawan.edit');
    Route::get('/karyawan/{name}/view', ViewKaryawan::class)->name('karyawan.view');

    Route::get('/pakan', PakanMain::class)->name('pakan');
    Route::get('/pakan/create', CreatePakan::class)->name('pakan.create');
    Route::get('/pakan/{id}/edit', EditPakan::class)->name('pakan.edit');
    Route::delete('/pakan/{id}/delete', PakanMain::class)->name('pakan.destroy');
});

require __DIR__.'/auth.php';
