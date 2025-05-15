<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\KaryawanMain;
use App\Livewire\Admin\Karyawan\CreateKaryawan;
use App\Livewire\Admin\Karyawan\EditKaryawan;
use App\Livewire\Admin\Karyawan\ViewKaryawan;
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
use App\Livewire\Admin\Pakan\CreatePakan;
use App\Livewire\Admin\pakan\EditPakan;
use App\Livewire\Admin\Chicken\ChickenPageAdmin;
use App\Livewire\Admin\Chicken\ChickenPageEmployee;
use App\Livewire\Admin\Egg\EggPageAdmin;
use App\Livewire\Admin\Egg\EggPageEmployee;

Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

Route::get('dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard')->middleware(['auth']);
Route::middleware(['auth', 'not.admin'])->group(function () {
    
    Route::get('/kandang', KandangMain::class)->name('kandang');
    Route::get('/kandang/create', CreateKandang::class)->name('kandang.create')->middleware('prevent.multiple.cage');
    Route::get('/kandang/{id}/edit', EditKandang::class)->name('kandang.edit');
    Route::get('/kandang/{id}/delete', KandangMain::class)->name('kandang.destroy');

    Route::get('/ayam', AyamMain::class)->name('ayam');
    Route::get('/ayam/create', CreateAyam::class)->name('ayam.create');
    Route::get('/ayam/{id}/edit', EditAyam::class)->name('ayam.edit');
    Route::get('/ayam/{id}/delete', AyamMain::class)->name('ayam.destroy');
    // Route::get('/ayam/filter', AyamMain::class)->name('ayam.filter');

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

    Route::get('/ayam', ChickenPageAdmin::class)->name('chicken.admin.index');
    Route::get('/ayam/{name}/view', ChickenPageEmployee::class)->name('chicken.admin.view');

    Route::get('/telur', EggPageAdmin::class)->name('egg.admin.index');
    Route::get('/telur/{name}/view', EggPageEmployee::class)->name('egg.admin.view');

    Route::get('/pakan', PakanMain::class)->name('pakan');
    Route::get('/pakan/create', CreatePakan::class)->name('pakan.create');
    Route::get('/pakan/{id}/edit', EditPakan::class)->name('pakan.edit');
});

Route::fallback(function () {
    return view('livewire.pages.404'); 
});

require __DIR__.'/auth.php';
