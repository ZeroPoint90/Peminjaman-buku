<?php

use App\Http\Controllers\User\BukuController as UserBukuController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\TransaksiController as UserTransaksiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\AdminProfilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\DashboardController;

//login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');


Route::post('/logout', [AuthController::class, 'logout']);

// ADMIN ONLY
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::resource('buku', BukuController::class)
            ->names('admin.buku');

        Route::resource('transaksi', AdminTransaksiController::class)
            ->only(['index', 'create', 'store', 'update'])
            ->names('admin.transaksi');

        Route::get('/member', [MemberController::class, 'index'])
            ->name('admin.member');

        Route::get('/setting', [AdminProfilController::class, 'settings'])
            ->name('admin.setting');
        Route::post('/update-theme', [AdminProfilController::class, 'updateTheme'])
            ->name('admin.update.theme');
        Route::patch(
            '/transaksi/{id}/force-kembali',
            [AdminTransaksiController::class, 'forceKembalikan']
        )->name('admin.force.kembali');
    });


// USER ONLY
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->group(function () {

        Route::get('/', [UserDashboardController::class, 'index'])
            ->name('user.dashboard');

        Route::get('/buku', [UserBukuController::class, 'index'])
            ->name('user.buku');

        Route::get('/transaksi', [UserTransaksiController::class, 'index'])
            ->name('user.transaksi');

        Route::post('/pinjam', [UserTransaksiController::class, 'store'])
            ->name('user.pinjam');

        Route::patch(
            '/transaksi/{id}/kembalikan',
            [UserTransaksiController::class, 'kembalikan']
        )
            ->name('user.transaksi.kembalikan');

        Route::get('/settings', [ProfilController::class, 'settings'])->name('user.settings');
        Route::post('/update-theme', [ProfilController::class, 'updateTheme'])->name('user.update.theme');
    });
