<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\SalesTransactionController;


Route::prefix('auth')->group(function () {
    // Rute login
    Route::post('login', [LoginController::class, 'login'])->name('login');

    // Rute register
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    // Rute logout
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth.jwt');
});

Route::prefix('admin')->middleware('auth.jwt')->group(function () {
    // Manajemen User
    Route::post('users', [UserController::class, 'store'])->name('users.store');  // Menambahkan user baru
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show'); // Menampilkan detail user
    Route::patch('users/{id}', [UserController::class, 'update'])->name('users.update'); // Mengupdate user
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // Menghapus user

    // Manajemen Menu
    Route::post('menus', [MenuController::class, 'store'])->name('menus.store');  // Menambahkan menu baru
    Route::get('menus/{id}', [MenuController::class, 'show'])->name('menus.show'); // Menampilkan detail menu
    Route::patch('menus/{id}', [MenuController::class, 'update'])->name('menus.update'); // Mengupdate menu
    Route::delete('menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy'); // Menghapus menu

    // Manajemen Laporan Penjualan
    Route::post('sales-reports', [SalesReportController::class, 'store'])->name('sales-reports.store');  // Menambahkan laporan penjualan
    Route::get('sales-reports/{id}', [SalesReportController::class, 'show'])->name('sales-reports.show'); // Menampilkan laporan penjualan
    Route::patch('sales-reports/{id}', [SalesReportController::class, 'update'])->name('sales-reports.update'); // Mengupdate laporan penjualan
    Route::delete('sales-reports/{id}', [SalesReportController::class, 'destroy'])->name('sales-reports.destroy'); // Menghapus laporan penjualan

    // Manajemen Transaksi Penjualan
    Route::post('sales-transactions', [SalesTransactionController::class, 'store'])->name('sales-transactions.store');  // Menambahkan transaksi penjualan
    Route::get('sales-transactions/{id}', [SalesTransactionController::class, 'show'])->name('sales-transactions.show'); // Menampilkan transaksi penjualan
    Route::patch('sales-transactions/{id}', [SalesTransactionController::class, 'update'])->name('sales-transactions.update'); // Mengupdate transaksi penjualan
    Route::delete('sales-transactions/{id}', [SalesTransactionController::class, 'destroy'])->name('sales-transactions.destroy'); // Menghapus transaksi penjualan
});