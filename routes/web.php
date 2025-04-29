<?php

use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarKendaraanController;
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
    Route::post('/merek-kendaraan/store', [PeminjamanController::class, 'tambahMerek'])->name('tambah.merek');
    Route::delete('/merek-kendaraan/{id}/delete', [PeminjamanController::class, 'hapusMerek'])->name('hapus.merek');

    // CRUD Daftar Kendaraan
    Route::post('/tambah-kendaraan', [DaftarKendaraanController::class, 'store'])->name('tambahkendaraan');
    Route::put('/edit-kendaraan/{id}', [DaftarKendaraanController::class, 'update'])->name('editkendaraan');
    Route::delete('/hapus-kendaraan/{id}', [DaftarKendaraanController::class, 'destroy'])->name('hapuskendaraan');

    Route::get('/timeline-peminjaman', [TimelineController::class, 'index'])->name('timeline-peminjaman');
    Route::put('/timeline-peminjaman/{id}', [TimelineController::class, 'update'])->name('timeline-peminjaman.update');
    Route::delete('/timeline-peminjaman/{id}', [TimelineController::class, 'destroy'])->name('timeline-peminjaman.destroy');

    Route::get('/daftar-permohonan', [DaftarPermohonanController::class, 'index'])->name('daftar-permohonan');
    Route::resource(name: 'daftar-permohonan', controller: DaftarPermohonanController::class)->except(['index']);
    Route::post('/daftar-permohonan/{id}/accept', [DaftarPermohonanController::class, 'accept']);
    Route::post('/daftar-permohonan/{id}/reject', [DaftarPermohonanController::class, 'reject']);

    Route::get('/permohonan-verifikasi', [VerifAkunController::class, 'index'])->name('permohonan-verifikasi');
    Route::post('/permohonan-verifikasi/{id}', [VerifAkunController::class, 'verifikasi'])->name('verifikasi.terima');
    Route::delete('/permohonan-verifikasi/{id}', [VerifAkunController::class, 'reject'])->name('verifikasi.tolak');

    Route::get('/peminjaman-saya', [PeminjamanController::class, 'peminjamanSaya'])->name('peminjaman.saya');
    Route::get('/peminjaman-saya/{id}/form-pengembalian', [PeminjamanController::class, 'formPengembalian'])->name('form.pengembalian');
    Route::put('/peminjaman-saya/{id}/kembalikan', [PeminjamanController::class, 'kembalikanKendaraan'])->name('pengembalian.kendaraan');

    Route::get('/user', [UsersController::class, 'index'])->name('user');
    Route::resource(name: 'user', controller: UsersController::class);
});