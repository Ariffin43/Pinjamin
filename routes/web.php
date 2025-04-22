<?php

use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarPermohonanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\VerifAkunController;

Route::get('/', function () {
    return view('landing-page');
});

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Peminjaman
    Route::get('/pinjam-kendaraan', [PeminjamanController::class, 'index'])->name('pinjam-kendaraan');
    Route::resource('pinjam-kendaraan', controller: PeminjamanController::class);
    Route::get('/form-peminjaman/{id}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    
    // CRUD Daftar Kendaraan
    Route::post('/tambah-kendaraan', [PeminjamanController::class, 'tambahkendaraan'])->name('tambahkendaraan');
    Route::post('/edit-kendaraan/{id}', [PeminjamanController::class, 'editkendaraan'])->name('editkendaraan');
    Route::delete('/hapus-kendaraan/{id}', [PeminjamanController::class, 'hapuskendaraan'])->name('hapuskendaraan');

    Route::get('/timeline-peminjaman', [TimelineController::class, 'index'])->name('timeline-peminjaman');
    Route::resource('timeline-peminjaman', controller: TimelineController::class);

    Route::get('/daftar-permohonan', [DaftarPermohonanController::class, 'index'])->name('daftar-permohonan');
    Route::resource(name: 'daftar-permohonan', controller: DaftarPermohonanController::class);
    Route::post('/daftar-permohonan/{id}/accept', [DaftarPermohonanController::class, 'accept']);
    Route::post('/daftar-permohonan/{id}/reject', [DaftarPermohonanController::class, 'reject']);

    Route::get('/permohonan-verifikasi', [VerifAkunController::class, 'index']);
    Route::post('/permohonan-verifikasi/{id}', [VerifAkunController::class, 'verifikasi'])->name('verifikasi.terima');
    Route::delete('/permohonan-verifikasi/{id}', [VerifAkunController::class, 'reject'])->name('verifikasi.tolak');


    Route::get('/user', [UsersController::class, 'index'])->name('user');
    Route::resource(name: 'user', controller: UsersController::class);
});