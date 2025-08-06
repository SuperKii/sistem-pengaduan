<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\CreateKeluhanPenghuniLivewire;
use App\Livewire\DashboardLivewire;
use App\Livewire\KategoriLivewire;
use App\Livewire\KeluhanDetailLivewire;
use App\Livewire\KeluhanLivewire;
use App\Livewire\KeluhanPenghuniLivewire;
use App\Livewire\LaporanLivewire;
use App\Livewire\LogActivityLivewire;
use App\Livewire\PenghuniLivewire;
use App\Livewire\PetugasLivewire;
use App\Livewire\ProfileLivewire;
use App\Livewire\StaffLivewire;
use Illuminate\Support\Facades\Route;

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
    return view('livewire.page.landingPage.index');
});


Route::middleware('auth.custom')->group(function () {
    Route::get('/dashboard', DashboardLivewire::class)->name('dashboard');
    Route::get('/kategori', KategoriLivewire::class)->name('kategori');
    Route::get('/penghuni', PenghuniLivewire::class)->name('penghuni');
    Route::get('/petugas', PetugasLivewire::class)->name('petugas');
    Route::get('/staff', StaffLivewire::class)->name('staff');
    Route::get('/keluhan', KeluhanLivewire::class)->name('keluhan');
    Route::get('/log-activity', LogActivityLivewire::class)->name('log-activity');
    Route::get('/laporan', LaporanLivewire::class)->name('laporan');
    Route::get('/keluhan-detail/{id}', KeluhanDetailLivewire::class)->name('keluhan-detail');

    // User
    Route::get('/keluhanPenghuni', KeluhanPenghuniLivewire::class)->name('keluhanPenghuni');
    Route::get('/CreateKeluhanPenghuni', CreateKeluhanPenghuniLivewire::class)->name('createKeluhanPenghuni');
    Route::get('/profile-user', ProfileLivewire::class)->name('profile');
});

require __DIR__ . '/auth.php';
